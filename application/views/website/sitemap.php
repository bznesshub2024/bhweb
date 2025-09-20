<?= header("Content-Type: text/xml;charset=iso-8859-1"); '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url();?></loc> 
        <priority>1.0</priority>
    </url>
	<url>
        <loc><?= base_url().'contact';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'about';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'term_and_conditions';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'privacy';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'refund';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'shipping_policy';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'feedback';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'faq';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'help';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'offersoffers';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'seller';?></loc> 
        <priority>0.5</priority>
    </url>
	<url>
        <loc><?= base_url().'track';?></loc> 
        <priority>0.5</priority>
    </url>
	
    <?php foreach($category as $category_data) { ?>
    <url>
        <loc><?= base_url().$category_data['cat_slug']; ?></loc>
        <priority>0.5</priority>
    </url>
    <?php } ?>
	
	<?php foreach($product as $product_data) { ?>
    <url>
		<loc><?= base_url().'product/'. $product_data['sku']; ?></loc>
        <priority>0.5</priority> 
    </url>
    <?php } ?>

</urlset> 