<?php

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


use Telegram\Bot\Api;

use App\SvcEquipType;
use App\PushMsg;
use App\User;
use App\MsgTemplate;
use App\Mail\PushEmail;

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


    public static function SendTGTest()
    {
        $bot_apikey = '542520829:AAGVBs-ZXApVczq2l-2VNDEi8u4fte8ADyE';
        $tg_chatid = '26488204';

        try
        {
            $telegram = new Api($bot_apikey);
            $response = $telegram->sendMessage([
                'chat_id' => $tg_chatid, 
                'text' => 'Dear ' . chr(10) .
                    'Your recently request (, request on ) has been approved.' . chr(10) . chr(10) .
                    'Management System Teams',
            ]);
        } 
        catch (\Exception $e)
        {
            return $e;
        }
        catch (Throwable $e)
        {
            return $e;
        }

        $parameters = array 
        (
            'user' => Auth::user()->name,
            'request_name' => 'request_name',
            'request_date' => 's',                
        );

        $pushmsg_record = new PushMsg();
        $pushmsg_record->msgtpl_id = 2;
        $pushmsg_record->user_id = Auth::user()->id;
        $pushmsg_record->parameters = $parameters;
        $pushmsg_record->save();
    }

    public static function GetTGMsg()
    {
        $pushmsg_record = PushMsg::findOrFail(1);
        $pushmsg_record->load('msg_template');

        $msg = CommonFunctionSet::GetMixedMessageText($pushmsg_record->msg_template->content, $pushmsg_record->parameters);
        Mail::to('worm.info@gmail.com')->send(new PushEmail($msg));
        
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

    /*
     * Push message functions
     */
    public static function PushMessageToQueue($user_id, $msg_key, $msg_parameters)
    {
        $userid_valid = false;
        if (User::where('id', $user_id)->count() == 1)
            $userid_valid = true;

        if (MsgTemplate::where('msgkey', $msg_key)->count() == 1 && $userid_valid)
        {
            $msgtpl_id = MsgTemplate::where('msgkey', $msg_key)->first()->id;

            $pushmsg_record = new PushMsg();
            $pushmsg_record->msgtpl_id = $msgtpl_id;
            $pushmsg_record->user_id = $userid_valid;
            $pushmsg_record->parameters = $msg_parameters;
            $pushmsg_record->save();
        }
    }

    public static function ProcessMessageFromQueue()
    {
        $records = PushMsg::all();
        foreach ($records as $pushmsg_record)
        {
            $pushmsg_record->load('msg_template');
            $user_record = User::find($pushmsg_record->user_id);

            $message = CommonFunctionSet::GetMixedMessageText
            (
                $pushmsg_record->msg_template->content, 
                $pushmsg_record->parameters
            );

            $tg_sendsuccess = false;
            $email_sendsuccess = false;
            if ($user_record->tg_usertoken != '')
            {
                $bot_apikey = '542520829:AAGVBs-ZXApVczq2l-2VNDEi8u4fte8ADyE';
                $tg_chatid = $user_record->tg_usertoken;
                try
                {
                    $telegram = new Api($bot_apikey);
                    $response = $telegram->sendMessage([
                        'chat_id' => $tg_chatid, 
                        'text' => $message,
                    ]);
                    $tg_sendsuccess = true;
                } 
                catch (\Exception $e)
                {
                    return $e;
                }
                catch (Throwable $e)
                {
                    return $e;
                }
            }

            if ($user_record->email != '')
            {
                $msg = CommonFunctionSet::GetMixedMessageText(
                    $pushmsg_record->msg_template->content, 
                    $pushmsg_record->parameters
                );
                try
                {
                    Mail::to($user_record->email)->send(new PushEmail($msg));
                    $email_sendsuccess = true;
                }
                catch (\Exception $e)
                {
                    return $e;
                }
                catch (Throwable $e)
                {
                    return $e;
                }
            }

            if ($tg_sendsuccess || $email_sendsuccess)
            {
                $pushmsg_record->tg_sent = $tg_sendsuccess ? 1 : 0;                
                $pushmsg_record->mail_sent = $email_sendsuccess ? 1 : 0;
                $pushmsg_record->update();
            }

            $pushmsg_record->delete();
        }
    }

    public static function GetMixedMessageText($msg, $vars)
    {
        $vars = (array)$vars;

        $msg = preg_replace_callback('#\{\}#', function($r){
            static $i = 0;
            return '{'.($i++).'}';
        }, $msg);

        return str_replace(
            array_map(function($k) {
                return '{'.$k.'}';
            }, array_keys($vars)),

            array_values($vars),

            $msg
        );
    }
}
