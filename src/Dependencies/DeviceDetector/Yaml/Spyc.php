<?php

/**
 * Device Detector - The Universal Device Detection library for parsing User Agents
 *
 * @link https://matomo.org
 *
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 */

declare(strict_types=1);

namespace Goyo_Statistics\Dependencies\DeviceDetector\Yaml;

use GoyoSpyc as SpycParser;

class Spyc implements ParserInterface
{
    /**
     * Parses the file with the given filename using GoyoSpyc and returns the converted content
     *
     * @param string $file
     *
     * @return mixed
     */
    public function parseFile(string $file)
    {
        return SpycParser::YAMLLoad($file);
    }
}
