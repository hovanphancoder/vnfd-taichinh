<?php 
namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
		View::composer(['layouts.header_contact', 'layouts.header'],'App\Http\ViewComposers\HeaderComposer');
		View::composer(['layouts.header_contact', 'layouts.footer'],'App\Http\ViewComposers\FooterComposer');
		View::composer(['layouts.sidebar_blog'],'App\Http\ViewComposers\SidebarComposer');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
