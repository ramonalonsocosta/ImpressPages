<?php
/**
 * @package   ImpressPages
 *
 *
 */

namespace Ip\Transform;

class None extends \Ip\Transform
{
    public function transform($sourceFile, $destinationFile)
    {
        copy($sourceFile, $destinationFile);
    }

}
