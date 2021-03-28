<?php namespace App\Http\ViewComposers;
use Illuminate\Contracts\View\View;
use App\Setting;
use App\Menu;
use App\MenuLanguage;
use Session;
use DB;
use App\Cart;
class HeaderComposer {
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $menu, $setting;
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Setting $setting, Menu $menu)
    {
        // Dependencies automatically resolved by service container...
        // $this->menus = array('1','2');
        $this->setting = $setting;
        $this->menu = $menu;
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $danh_muc_san_pham = Menu::where('id_catemenu', 1)->get()->toArray();
        $view->with('footer', $this->setting->getSetting(5));
        $view->with('menutop', $this->menu->getListCate(3));
        $view->with('social', $this->setting->getSetting(3));
        $view->with('header', $this->setting->getSetting(4));
        $view->with('header_category', $danh_muc_san_pham);

        // dd($menu_danhmuc);
        // $view->with('viewed','da xem');
    }
    
}