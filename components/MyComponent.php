<?php  
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class MyComponent extends Component
{
	public function MyFunction($param1,$param2){
		return $param1+$param2; // (:)
	}

	public function Siteurl()
	{
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'].'/';
        return $protocol.$domainName;
	}
	public function dateformat($date,$exp="-")
    {
        if(!empty($date))
        {
            $exped=explode($exp, $date);
            return $exped[2].$exp.$exped[1].$exp.$exped[0];
        }
        else
        {
            return false;
        }
    }
    public function Simplmail($to,$subject,$message,$from,$fromname)
    {       
        $headers = "From: $fromname <{$from}>\r\n" .
                "Reply-To: {$from}\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/html; charset=UTF-8";
        $return = mail($to, $subject, $message, $headers);
        return $return;
    }
    public function Imagecroper($filenames,$targetfolder,$newfilename,$width,$height)       ///My Image Croper 
    {
        // The file
        $filename = $filenames;        
        // Set a maximum height and width
        $width = $width;
        $height = $height;  
        // Get new dimensions
        list($width_orig, $height_orig) = getimagesize($filename);        
        if ($width && ($width_orig < $height_orig)) {
            $width = ($height / $height_orig) * $width_orig;
        } else {
            $height = ($width / $width_orig) * $height_orig;
        }        
        // Resample
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig); 
        if(!is_dir($targetfolder))
        {
            mkdir($targetfolder);
        }
        $flo = $targetfolder.$newfilename;
        // Output
        imagejpeg($image_p, $flo, 100);
    }
}

?>