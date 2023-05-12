<?php


namespace File\Ajax;


use Authorization\Authorization;
use Authorization\Exceptions\UnauthorizedException;
use Common\PageAjaxController;

class File extends PageAjaxController
{
    public function upload($file, $other)
    {
        if(!Authorization::isLogged()) throw new UnauthorizedException();
        return (new \File\File())->upload($file);
    }

}