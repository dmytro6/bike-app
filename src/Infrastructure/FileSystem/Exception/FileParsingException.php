<?php

declare (strict_types=1);

namespace App\Infrastructure\FileSystem\Exception;

/**
 * Exception is thrown when there is an error reaching the client
 *
 */
class FileParsingException extends \RuntimeException
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct('Error while trying to parse the file', 0, $previous);
    }
}
