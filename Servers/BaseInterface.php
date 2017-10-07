<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 16:28
 */

namespace EShine\Servers;

require __DIR__ . '/../vendor/autoload.php';

interface BaseInterface
{
    /**
     * @return string
     */
    function collectName();

    /**
     * @param string $name
     * @return string
     */
    function getPropertyDesc($name);

    /**
     * @return mixed
     */
    function getSelfVar();
}