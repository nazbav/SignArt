<?php
declare(strict_types = 1);


namespace joker2620\SingArt;


/**
 * Class SignArt
 *
 * @package joker2620\Source\Plugins\AutoSing
 */
class SignArt
{

    private $imageDirectory;
    private $image;
    private $images;
    private $data;

    /**
     * generate()
     *
     * @param string $text
     * @param array  $color
     * @param string $fonts
     *
     * @return string
     */
    public function generate(
        string $text,
        array $color = [0, 0, 0],
        string $fonts = 'PFKidsPro-GradeOne.ttf'
    ) {
        $fonts = $this->buildPath(
            $this->getDirectory(),
            $fonts
        );
        $this->getRandImg();
        $color = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
        $sizof = round($this->data[1] / mb_strlen($text));
        imagettftext(
            $this->image,
            $sizof > $this->data[1] ? $this->data[2] : $sizof,
            $this->data[5],
            $this->data[3],
            $this->data[4],
            $color,
            $fonts,
            $text
        );
        $fileimage = $this->buildPath(
            $this->getDirectory(),
            random_int(100, 1000000) . '.png'
        );
        imagepng($this->image, $fileimage);
        imagedestroy($this->image);
        return $fileimage;
    }

    /**
     * buildPath()
     *
     * @param array ...$element
     *
     * @return string
     */
    public function buildPath(...$element)
    {
        return join(DIRECTORY_SEPARATOR, $element);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getDirectory()
    {
        if (!empty($this->imageDirectory)) {
            return $this->imageDirectory;
        } else {
            throw new \Exception('Image directory is empty.');
        }
    }

    public function getRandImg()
    {
        $base_art    = include '../config/Config.php';
        $datas       = $base_art[array_rand($base_art)];
        $files       = $this->buildPath(
            $this->getDirectory(),
            $datas['imageFile']
        );
        $this->image = imagecreatefrompng($files);
        $this->data  = $datas;
    }

    /**
     * @param $ImageDirectory
     *
     * @internal param mixed $imgDir
     */
    public function setDirectory($ImageDirectory)
    {
        $this->imageDirectory = $ImageDirectory;
    }

    /**
     * registerImages()
     *
     * @param array $image
     */
    public function addImages(array $image)
    {
        $this->images[] = $image;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * imageDestroy()
     *
     * @param string $file_image
     */
    public function imageDestroy(string $file_image)
    {
        if (file_exists($file_image)) {
            unlink($file_image);
        }
    }
}
