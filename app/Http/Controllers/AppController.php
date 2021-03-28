<?php

namespace App\Http\Controllers;
use App\Menu;
use App\Setting;
use App\Categorypost;
use App\Section;
use Illuminate\View\View;

class AppController extends Controller {
    public function __construct() {
    }
    
    public function treeCategoryPost($parent_id = 0, &$submark = []) {
        $submark[] = $parent_id;
        $query = Categorypost::getListCategoryParent($parent_id);
        // dd($query->toArray());
        if ($query) {
            foreach ($query as $count => $catepost) {
                $submark[] = $catepost->id;
                $this->treeCategoryPost($catepost->id, $submark);
            }
        }
        return $submark;
    }
}
?>