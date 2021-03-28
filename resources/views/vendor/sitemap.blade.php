<?php 
//dd($listTag);
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
	foreach($posts as $post){
        echo '<url>';
        echo '<loc>'.secure_url($post->cateslug_vn.'/'.$post->slug_vn).'</loc>';
		echo '<lastmod>'.date("Y-m-d",strtotime($post->created_at)).' '.date("h:i",strtotime($post->created_at)).' +00:00</lastmod>';
		echo '<changefreq>daily</changefreq>';
		echo '<priority>0.9</priority>';
		echo '</url>';
    }
	foreach($listTag as $count_tag => $tag){
		echo '<url>';
		echo '<loc>'.secure_url('tag/'.$tag['slug']).'</loc>';
		echo '<lastmod>'.date("Y-m-d",strtotime($tag['created_at'])).' '.date("h:i",strtotime($tag['created_at'])).' +00:00</lastmod>';
		echo '<changefreq>daily</changefreq>';
		echo '<priority>';
		echo '0.8';
		echo '</priority>';
		echo '</url>';
	}
    foreach($pages as $count => $page){
		if($page->slug_vn != "thong-bao"){
			echo '<url>';
			if($page->slug_vn == "trang-chu"){
				echo '<loc>'.secure_url('/').'</loc>';
			}else{
				echo '<loc>'.secure_url($page->slug_vn).'</loc>';
			}
			echo '<lastmod>'.date("Y-m-d",strtotime($page->created_at)).' '.date("h:i",strtotime($page->created_at)).' +00:00</lastmod>';
			echo '<changefreq>monthly</changefreq>';
			echo '<priority>';
			if($count == 0){
				echo '1.00';
			}else{
				echo '0.8';
			}
			echo '</priority>';
			echo '</url>';
		}
    }
echo '</urlset>';
?>