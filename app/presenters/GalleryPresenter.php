<?php

/**
 * Gallery presenter.
 *
 * @author     Milos Kozak
 * @package    Nette gallery
 */

use Nette\Utils\Finder;
use Nette\Image;

class GalleryPresenter extends BasePresenter
{

	/**
	 * @param  Url - address to eigher directory or file
	 * @return void
	 */
	public function renderDefault($url)
	{
		$full_url = implode("/", array(PICS_DIR, $url));
		if( is_dir($full_url )){
			/*  handle as directory */
			
			// Directories
			$this->template->dirs= Finder::findDirectories('*')->in($full_url);
			
			// Files
			$this->template->files= Finder::findFiles('*.jpg', '*.png','*.gif','*.JPG')->in($full_url);
			
			// Current url
			$this->template->directory= $full_url;
			
			
		} else{
			// Handle as file
		}
		
		$this->template->url= $url;
		$this->template->root= PICS_DIR;
	}
	
	public function renderThumbnail($url)
	{

		// Security check of directory
		$path= realpath(implode('/', array(PICS_DIR,$url)));
		if( !strstr( $path, realpath(PICS_DIR)) or !file_exists($path))
			throw new Nette\Application\BadRequestException;
		
		$hash_file= implode("/", array(CACHE_DIR, 'thumb_'.md5($url).".jpg") );
		
		if( ! file_exists($hash_file) ){ 
			$filename= implode("/", array(PICS_DIR, $url));
			$image = Image::fromFile($filename);
			$image->resize(THUMB_SIZE, THUMB_SIZE, Image::FILL);
				 
			// Inteligentni zmenseni
			$image->crop($image->width/2-THUMB_SIZE/2, $image->height/2-THUMB_SIZE/2, THUMB_SIZE,THUMB_SIZE);
			$image->sharpen();
			$image->save($hash_file, 80, Image::JPEG);
		}
			
		$image = Image::fromFile($hash_file);
		$image->send();
		
	}
	
	public function renderPreview($url)
	{
		// Security check of directory
		$path= realpath(implode('/', array(PICS_DIR,$url)));
		if( !strstr( $path, realpath(PICS_DIR)) or !file_exists($path))
			throw new Nette\Application\BadRequestException;
		
		$filename= implode("/", array(PICS_DIR, $url));
		$image = Image::fromFile($filename);
		
		if( FORCE_IMAGE_SIZE and ($image->width > IMAGE_SIZE or $image->height > IMAGE_SIZE) ){
			// Shrink upto FORCE_IMAGE_SIZExFORCE_IMAGE_SIZE
			$image->resize(IMAGE_SIZE, IMAGE_SIZE, Image::FIT);
			$image->save( $filename );
			$image = Image::fromFile($filename);
		}
		
		$image->send();
	}

}
