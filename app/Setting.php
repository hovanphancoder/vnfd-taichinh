<?php



namespace App;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Setting extends Model {
    //
    protected $table = 'setting';
    protected $fillable = ['name', 'config'];
    public function setMail() {
        return DB::table('setting')->whereId(1)->first();
    }
    
    // public function getSetting($id){
    //     return DB::table('setting')
    //             ->whereId($id)
    //             ->select('name', 'config')
    //             ->first();
    // }
     public function getSetting($id){
        return DB::table('setting')
            
                ->whereId($id)
                ->select('name', 'config')
                ->first();
    }
	public function getSettingFooter($name){
        return DB::table('setting')->where('name',$name)->get();
    }
    
    public function updateSocial($id, $facebook, $youtube, $googleplus, $twitter, $linkedin, $instagram, $skype, $whatsapp){
        return DB::table('setting')
                        ->where('id', $id)
                        ->update(['config' => ''
                            . '{"facebook":"' . $facebook . '",'
                            . '"youtube":"' . $youtube . '",'
                            . '"google-plus":"' . $googleplus . '",'
                            . '"linkedin":"' . $linkedin . '",'
                            . '"instagram":"' . $instagram . '",'
                            . '"skype":"' . $skype . '",'
                            . '"whatsapp":"' . $whatsapp . '",'
                            . '"twitter":"' . $twitter . '"}'

        ]);
    }
	public function updateCurrency($id, $usd){
        return DB::table('setting')
                        ->where('id', $id)
                        ->update(['config' => ''
                            . '{"usd":"' . $usd . '"}'

        ]);
    }
    public function updateHeader($id, $logo, $hotline, $email){
        return DB::table('setting')
                        ->where('id', $id)
                        ->update(['config' => ''
                            . '{"logo":"' . $logo . '",'
                            . '"hotline":"' . $hotline . '",'
                            . '"email":"' . $email . '"}'
        ]);
    }
    
    public function updateFooter($id, $copyright, $development, $phone, $address, $link){
        return DB::table('setting')
                        ->where('id', $id)
                        ->update(['config' => ''
                            . '{"copyright":"' . $copyright . '",'
                            . '"development":"' . $development . '",'
                            . '"phone":"' . $phone . '",'
                            . '"address":"' . $address . '",'
                            . '"link":"' . $link . '"}'

        ]);
    }
	public function updateFooterLanguage($name, $copyright, $development, $phone, $address, $link, $language_id){
        return DB::table('setting')
                        ->where('name', 'footer')
                        ->where('lang_id', $language_id)
                        ->update(['config' => ''
                            . '{"copyright":"' . $copyright . '",'
                            . '"development":"' . $development . '",'
                            . '"phone":"' . $phone . '",'
                            . '"address":"' . $address . '",'
                            . '"link":"' . $link . '"}'

        ]);
    }

    public function updateMail($name, $title, $from, $cc) {

        return DB::table('setting')

                        ->where('id', 1)

                        ->update(['config' => ''

                            . '{"name":"' . $name . '",'

                            . '"title":"' . $title . '",'

                            . '"from":"' . $from . '",'

                            . '"cc":"' . $cc . '"}'

        ]);

    }



    public function getMail() {

        return DB::table('setting')->whereId(1)->first();

    }



    public function getAds() {

        return DB::table('setting')->whereId(2)->first();

    }



    public function setAdvertising($name, $config) {

        return DB::table('setting')

                        ->where('id', 2)

                        ->update([

                            'name' => $name,

                            'config' => $config

        ]);

    }

    

    public function getAdvertising()

    {

        return DB::table('setting')->whereId(2)->first();

    }



}