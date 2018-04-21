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
            base64_encode($text) . '.png'
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
    private function buildPath(...$element)
    {
        return join(DIRECTORY_SEPARATOR, $element);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function getDirectory()
    {
        if (!empty($this->imageDirectory)) {
            return $this->imageDirectory;
        } else {
            throw new \Exception('Image directory is empty.');
        }
    }

    private function getRandImg()
    {
        $datas       = $this->getImages()[array_rand($this->getImages())];
        $files       = $this->buildPath(
            $this->getDirectory(),
            $datas[0]
        );
        $this->image = imagecreatefrompng($files);
        $this->data  = $datas;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function getImages()
    {
        if (!empty($this->images)) {
            return $this->images;
        } else {
            throw new \Exception('Images is empty.');
        }
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
     *
     * @return $this
     */
    public function addImage(array $image)
    {
        $this->images[] = $image;
        return $this;
    }

    /**
     * addImageBase()
     *
     * @param array $image
     */
    public function addImageBase(array $image)
    {
        $this->images = $image;
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
