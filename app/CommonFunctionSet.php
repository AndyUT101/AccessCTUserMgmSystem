<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Telegram\Bot\Api;

use App\SvcEquipType;

class CommonFunctionSet extends Model
{
    public static function get_menuitem()
    {
        return SvcEquipType::All();
    }

    /*
     * Telegram Functions
     * 
     * 
     * 
     */

    public static function TestTelegramBot($dtlinfo)
    {
        $bot_apikey = '542520829:AAGVBs-ZXApVczq2l-2VNDEi8u4fte8ADyE';
        $bot_apikey = '643549455:AAFpUJiqdMVN-GExKonUFL-FBq5jbzrgZsw';
        $tg_chatid = '-310388494';
        $tg_chatid = '-314657565';

        $telegram = new Api($bot_apikey);
        $response = $telegram->sendMessage([
            'chat_id' => $tg_chatid, 
            'text' => 'Dear team: Hello world. From ' . $dtlinfo,
        ]);
    }

    public static function SendApplyMsgToTG($request_object)
    {
        $bot_apikey = '542520829:AAGVBs-ZXApVczq2l-2VNDEi8u4fte8ADyE';
        $bot_apikey = '643549455:AAFpUJiqdMVN-GExKonUFL-FBq5jbzrgZsw';
        $tg_chatid = '-310388494';
        $tg_chatid = '-314657565';

        $telegram = new Api($bot_apikey);
        $response = $telegram->sendMessage([
            'chat_id' => $tg_chatid, 
            'text' => 'Dear ' . $request_object->user->name . ':' . chr(10) .
                'Your have submitted a request (' . $request_object->svc_equip_item->name .', on ' . $request_object->created_at . ').' . chr(10) . chr(10) .
                'Management System Teams',
        ]);
    }

    public static function SendSuccessMsgToTG($request_object)
    {
        $bot_apikey = '542520829:AAGVBs-ZXApVczq2l-2VNDEi8u4fte8ADyE';
        $bot_apikey = '643549455:AAFpUJiqdMVN-GExKonUFL-FBq5jbzrgZsw';
        $tg_chatid = '-310388494';
        $tg_chatid = '-314657565';

        $telegram = new Api($bot_apikey);
        $response = $telegram->sendMessage([
            'chat_id' => $tg_chatid, 
            'text' => 'Dear ' . $request_object->user->name . ':' . chr(10) .
                'Your recently request (' . $request_object->svc_equip_item->name .', request on ' . $request_object->created_at . ') has been approved.' . chr(10) . chr(10) .
                'Management System Teams',
        ]);
    }

    public static function SendRejectMsgToTG($request_object)
    {
        $bot_apikey = '542520829:AAGVBs-ZXApVczq2l-2VNDEi8u4fte8ADyE';
        $bot_apikey = '643549455:AAFpUJiqdMVN-GExKonUFL-FBq5jbzrgZsw';
        $tg_chatid = '-310388494';
        $tg_chatid = '-314657565';

        $telegram = new Api($bot_apikey);
        $response = $telegram->sendMessage([
            'chat_id' => $tg_chatid, 
            'text' => 'Dear ' . $request_object->user->name . ':' . chr(10) .
                'Your recently request (' . $request_object->svc_equip_item->name .', request on ' . $request_object->created_at . ') has been rejected.' . chr(10) . chr(10) .
                'Management System Teams',
        ]);
    }


    /*
     * Permission functions
     */
    public static function RejectUserAccess($required_level)
    {
        Auth::user()->load('user_type');
        $user_typelevel = Auth::user()->user_type->typelevel;

        return $required_level > $user_typelevel;
    }
}
