<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10.05.2022
 * Time: 21:06
 */

namespace App\Http\Controllers\API\v1;


use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function createFeedback(Request $request)
    {
        $request->validate([
           'supplier_id' => "required",
           'comment'     => "required",
           "star"        => "required"
        ]);

        $data = [
            "supplier_id" => $request->supplier_id,
            "comment" => $request->comment,
            "user_id" => request()->user()->id,
            "star" => (int)$request->star
        ];

        Feedback::create($data);

        return [
            'success'  => true,
            'message'  => "Отзыв успешно оставлен"
        ];
    }
}