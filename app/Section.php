<?php



namespace App;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Section extends Model {
    
    protected $table = 'section';



    //

    public function getListSection() {

        return DB::table('section')->orderBy('created_at', 'desc')->get();

    }



    public function getSectionHotline($id) {

        return DB::table('section')->whereId($id)->first();

    }



    public function getSection($id) {
        // return DB::table('section')->whereId($id)->select($array)->first();
        $query = DB::table('section');
        $query->join('section_language','section.id','=','section_language.section_id');
        $query->where('section_language.section_id', $id);
        $query->where('section_language.language_id', get_id_locale());
        $query->select('section_language.title','section_language.image','section_language.description','section_language.link','section_language.setting');
        return $query->first();
    }



    public function getChosenSection($ids,$array = []) {

        return DB::table('section')->whereIn('id', $ids)
                ->select($array)
                ->get();

    }



    public function getListId() {

        return DB::table('section')->pluck('id');

    }



    public function updateSection($lang, $id, $name, $title, $description, $image, $video, $link) {

        if ($lang == "en") {

            return DB::table('section')

                            ->where('id', $id)

                            ->update([

                                'name' => $name,

                                'title_en' => $title,

                                'description_en' => $description,

                                'image' => $image,

                                'link' => $link,

                                'video' => $video

            ]);

        } else {

            return DB::table('section')

                            ->where('id', $id)

                            ->update([

                                'name' => $name,

                                'title' => $title,

                                'description' => $description,

                                'image' => $image,

                                'link' => $link,

                                'video' => $video

            ]);

        }

    }



    public function viewSection($id) {

        return DB::table('section')->whereId($id)->first();

    }

    public function getListSectionSlug($slug){
        return DB::table('section')->where('name',$slug)->get();
    }
}

