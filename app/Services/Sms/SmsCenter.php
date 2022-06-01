<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 01.06.2022
 * Time: 19:00
 */

namespace App\Services\Sms;

use Exception;

define("SMSC_HOST", "212.124.121.186");
define("SMSC_PORT", 7780);
define("SMSC_LOGIN", "bidpro");
define("SMSC_PASSWORD", "PMYS224wn");
define("SMSC_CHARSET", "utf-8");

class SmsCenter
{
    private $socket;
    private $sequence_number = 1;

    public function __construct()
    {
        $ip = gethostbyname(SMSC_HOST);

        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if (!$this->socket || !socket_connect($this->socket, $ip, SMSC_PORT))
            throw new Exception(socket_strerror(socket_last_error()));

        if (!$this->bind()) {
            throw new Exception("Bind error");
        }
    }

    public function __destruct()
    {
        if ($this->socket) {
            $this->unbind();
            socket_close($this->socket);
        }
    }

    private function sendPdu($pdu)
    {
        $length = strlen($pdu);

        if ($this->socket && socket_write($this->socket, $pdu, $length) == $length) {
            $reply = unpack("Nlen/Ncmd_id/Nstatus/Nseq/a*data", $this->readPdu());

            if ($reply['seq'] == $this->sequence_number++ && $reply['status'] == 0) {
                return $reply['data'];
            }
        }

        return false;
    }

    private function readPdu()
    {
        $pdu = "";
        $wait_sec = 4;

        while (socket_recv($this->socket, $pdu, 16, MSG_WAITALL) != 16 && --$wait_sec >= 0)
            sleep(1);

        if ($wait_sec >= 0) {
            $header = unpack("N4", $pdu);
            $pdu .= socket_read($this->socket, $header[1] - 16); // body
        }

        return $pdu;
    }

    private function bind($system_type = '')
    {
        $pdu = pack("a" . strlen(SMSC_LOGIN) . "xa" . strlen(SMSC_PASSWORD) . "xa" . strlen($system_type) . "xCCCx", SMSC_LOGIN, SMSC_PASSWORD, $system_type, 0x34, 5, 1); // body
        $pdu = pack("NNNN", strlen($pdu) + 16, 0x02/*BIND_TRANSMITTER*/, 0, $this->sequence_number) . $pdu; // header + body

        return $this->sendPdu($pdu);
    }

    public function unbind()
    {
        $pdu = pack("NNNN", 16, 0x06/*UNBIND*/, 0, $this->sequence_number);
        $this->sendPdu($pdu);
    }

    public function sendMessage($phone, $message, $sender = ".", $valid = "", $use_tlv = true, $time = "")
    {
        //dd($phone);
        if (preg_match('/[`\x80-\xff]/', $message)) { // is UCS chars
            $message = iconv(SMSC_CHARSET, "UTF-16BE", $message);
            $coding = 2; // UCS2
        } else
            $coding = 0; // 7bit

        if (!$use_tlv && strlen($message) > 255)
            $use_tlv = true;

        $sm_length = strlen($message);

        if ($valid) {
            $valid = min((int)$valid, 24 * 60);
            $valid = sprintf('0000%02d%02d%02d00000R', (int)($valid / 1440), ($valid % 1440) / 60, $valid % 60);
        }

        if ($time) {
            if (strlen($time) == 12) {
                preg_match('~^(\d\d)(\d\d)(\d{4})(\d\d)(\d\d)$~', $time, $m);
                $time = mktime($m[4], $m[5], 0, $m[2], $m[1], $m[3]);
            }

            $tz = (int)(date('Z', $time) / (15 * 60));
            $time = date('ymdHi', $time) . '000' . str_pad(abs($tz), 2, '0', STR_PAD_LEFT) . ($tz >= 0 ? '+' : '-');
        }

        $pdu = pack("xCCa" . strlen($sender) . "xCCa" . strlen($phone) . "xCCCa" . strlen($time) . "xa" . strlen($valid) . "xCCCC", // body
                5,            // source_addr_ton
                1,            // source_addr_npi
                $sender,    // source_addr
                1,            // dest_addr_ton
                1,            // dest_addr_npi
                $phone,        // destination_addr
                0,            // esm_class
                0,            // protocol_id
                3,            // priority_flag
                $time,            // schedule_delivery_time
                $valid,        // validity_period
                0,            // registered_delivery_flag
                0,            // replace_if_present_flag
                $coding * 4,// data_coding
                0) .            // sm_default_msg_id

            ($use_tlv ? "\0\x04\x24" . pack("n", $sm_length) : chr($sm_length)) . // TLV message_payload tag OR sm_length + short_message

            $message;    // text message

        $pdu = pack("NNNN", strlen($pdu) + 16, 0x04/*SUBMIT_SM*/, 0, $this->sequence_number) . $pdu; // header + body

        return $this->sendPdu($pdu);
    }

}