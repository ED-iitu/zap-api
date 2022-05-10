@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Запчасти <a href="{{route('products.create')}}" type="button">Добавить</a> / <a href="{{route('importProduct')}}">Импортировать</a></h3>
                <div class="panel panel-default">
                    <div class="panel-heading"></div>

                    <div class="panel-body">
                        <table class="table" id="datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Название</th>
                                <th>Компания</th>
                                <th>Article</th>
                                <th>Цена</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><img src="{{$product->image}}" alt="" width="100" height="100"></td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->company->name }}</td>
                                    <td>{{ $product->article }}</td>
                                    <td>{{$product->price}} KZT</td>
                                    <td>
                                        <form action="{{ route('products.destroy',$product) }}" method="POST">
                                            <a class="btn btn-primary edit" href="{{ route('products.edit', $product) }}">Изменить</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger edit" onclick="return confirm('Вы действительно хотите удалить товар?')">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js" defer></script>
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показать _MENU_ записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    },
                    "select": {
                        "rows": {
                            "_": "Выбрано записей: %d",
                            "1": "Выбрана одна запись"
                        },
                        "cells": {
                            "1": "1 ячейка выбрана",
                            "_": "Выбрано %d ячеек"
                        },
                        "columns": {
                            "1": "1 столбец выбран",
                            "_": "%d столбцов выбрано"
                        }
                    },
                    "searchBuilder": {
                        "conditions": {
                            "string": {
                                "startsWith": "Начинается с",
                                "contains": "Содержит",
                                "empty": "Пусто",
                                "endsWith": "Заканчивается на",
                                "equals": "Равно",
                                "not": "Не",
                                "notEmpty": "Не пусто",
                                "notContains": "Не содержит",
                                "notStarts": "Не начинается на",
                                "notEnds": "Не заканчивается на"
                            },
                            "date": {
                                "after": "После",
                                "before": "До",
                                "between": "Между",
                                "empty": "Пусто",
                                "equals": "Равно",
                                "not": "Не",
                                "notBetween": "Не между",
                                "notEmpty": "Не пусто"
                            },
                            "number": {
                                "empty": "Пусто",
                                "equals": "Равно",
                                "gt": "Больше чем",
                                "gte": "Больше, чем равно",
                                "lt": "Меньше чем",
                                "lte": "Меньше, чем равно",
                                "not": "Не",
                                "notEmpty": "Не пусто",
                                "between": "Между",
                                "notBetween": "Не между ними"
                            },
                            "array": {
                                "equals": "Равно",
                                "empty": "Пусто",
                                "contains": "Содержит",
                                "not": "Не равно",
                                "notEmpty": "Не пусто",
                                "without": "Без"
                            }
                        },
                        "data": "Данные",
                        "deleteTitle": "Удалить условие фильтрации",
                        "logicAnd": "И",
                        "logicOr": "Или",
                        "title": {
                            "0": "Конструктор поиска",
                            "_": "Конструктор поиска (%d)"
                        },
                        "value": "Значение",
                        "add": "Добавить условие",
                        "button": {
                            "0": "Конструктор поиска",
                            "_": "Конструктор поиска (%d)"
                        },
                        "clearAll": "Очистить всё",
                        "condition": "Условие",
                        "leftTitle": "Превосходные критерии",
                        "rightTitle": "Критерии отступа"
                    },
                    "searchPanes": {
                        "clearMessage": "Очистить всё",
                        "collapse": {
                            "0": "Панели поиска",
                            "_": "Панели поиска (%d)"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Нет панелей поиска",
                        "loadMessage": "Загрузка панелей поиска",
                        "title": "Фильтры активны - %d",
                        "showMessage": "Показать все",
                        "collapseMessage": "Скрыть все"
                    },
                    "thousands": ",",
                    "buttons": {
                        "pageLength": {
                            "_": "Показать 10 строк",
                            "-1": "Показать все ряды"
                        },
                        "pdf": "PDF",
                        "print": "Печать",
                        "collection": "Коллекция <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                        "colvis": "Видимость столбцов",
                        "colvisRestore": "Восстановить видимость",
                        "copy": "Копировать",
                        "copyKeys": "Нажмите ctrl or u2318 + C, чтобы скопировать данные таблицы в буфер обмена.  Для отмены, щелкните по сообщению или нажмите escape.",
                        "copySuccess": {
                            "1": "Скопирована 1 ряд в буфер обмена",
                            "_": "Скопировано %ds рядов в буфер обмена"
                        },
                        "copyTitle": "Скопировать в буфер обмена",
                        "csv": "CSV",
                        "excel": "Excel"
                    },
                    "decimal": ".",
                    "infoThousands": ",",
                    "autoFill": {
                        "cancel": "Отменить",
                        "fill": "Заполнить все ячейки <i>%d<i><\/i><\/i>",
                        "fillHorizontal": "Заполнить ячейки по горизонтали",
                        "fillVertical": "Заполнить ячейки по вертикали"
                    },
                    "datetime": {
                        "previous": "Предыдущий",
                        "next": "Следующий",
                        "hours": "Часы",
                        "minutes": "Минуты",
                        "seconds": "Секунды",
                        "unknown": "Неизвестный",
                        "amPm": [
                            "AM",
                            "PM"
                        ],
                        "months": {
                            "0": "Январь",
                            "1": "Февраль",
                            "10": "Ноябрь",
                            "11": "Декабрь",
                            "2": "Март",
                            "3": "Апрель",
                            "4": "Май",
                            "5": "Июнь",
                            "6": "Июль",
                            "7": "Август",
                            "8": "Сентябрь",
                            "9": "Октябрь"
                        },
                        "weekdays": [
                            "Вс",
                            "Пн",
                            "Вт",
                            "Ср",
                            "Чт",
                            "Пт",
                            "Сб"
                        ]
                    },
                    "editor": {
                        "close": "Закрыть",
                        "create": {
                            "button": "Новый",
                            "title": "Создать новую запись",
                            "submit": "Создать"
                        },
                        "edit": {
                            "button": "Изменить",
                            "title": "Изменить запись",
                            "submit": "Изменить"
                        },
                        "remove": {
                            "button": "Удалить",
                            "title": "Удалить",
                            "submit": "Удалить",
                            "confirm": {
                                "_": "Вы точно хотите удалить %d строк?",
                                "1": "Вы точно хотите удалить 1 строку?"
                            }
                        },
                        "multi": {
                            "restore": "Отменить изменения",
                            "title": "Несколько значений",
                            "noMulti": "Это поле должно редактироватся отдельно, а не как часть групы"
                        },
                        "error": {
                            "system": "Возникла системная ошибка (<a target=\"\\\" rel=\"nofollow\" href=\"\\\">Подробнее<\/a>)"
                        }
                    },
                    "searchPlaceholder": "Что ищете?"
                }
            });
        });
    </script>
@endsection