<?php

declare(strict_types=1);

namespace Doctrine\DBAL\Exception;

/**
 * Base class for all server related errors detected in the driver.
 *
 * @psalm-immutable
 */
class ServerException extends DriverException
{
}
