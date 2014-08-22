<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\DirectoryManagerInterface;

class DirectoryManager implements DirectoryManagerInterface{




    /**
     * reads first parameter directory FILES, "ignoring second parameter patterns"
     * and return an array of full paths of files found
     *
     */
    public function directoryReader(Array $included_directories, $ignored_patterns){

        /**
            a. build an array of “full path of each file” inside each directory from the “included dir array”.
            b. extract any file that belongs to the array of denied things (directories, files, extensions or patterns)
            c. return an array of “full path of each allowed file”.
         */

    }












} 