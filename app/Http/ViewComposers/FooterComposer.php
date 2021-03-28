<?php 
namespace App\Http\ViewComposers;
use Illuminate\Contracts\View\View;
use App\Setting;
use App\Menu;
use App\Post;
class FooterComposer {
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    // protected $menus = [];
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Post $post, Setting $setting, Menu $menu)
    {
        // Dependencies automatically resolved by service container...
        // $this->menus = array('1','2');
        $this->setting = $setting;
        $this->menu = $menu;
        $this->post = $post;
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('footer', $this->setting->getSetting(5));
        $view->with('quicklink', $this->menu->getListCate(2));
        $view->with('social', $this->setting->getSetting(3));
        $view->with('header', $this->setting->getSetting(4));
       
    }
}