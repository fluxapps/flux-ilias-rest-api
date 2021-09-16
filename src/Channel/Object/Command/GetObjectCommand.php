<?php

namespace Fluxlabs\FluxIliasRestApi\Channel\Object\Command;

use Fluxlabs\FluxIliasRestApi\Adapter\Api\Object\ObjectDto;
use Fluxlabs\FluxIliasRestApi\Channel\Object\ObjectQuery;
use ilDBInterface;
use LogicException;

class GetObjectCommand
{

    use ObjectQuery;

    private ilDBInterface $database;


    public static function new(ilDBInterface $database) : /*static*/ self
    {
        $command = new static();

        $command->database = $database;

        return $command;
    }


    public function getObjectById(int $id) : ?ObjectDto
    {
        $object = null;
        while (($object_ = $this->database->fetchAssoc($result ??= $this->database->query($this->getObjectQuery(
                null,
                $id
            )))) !== null) {
            if ($object !== null) {
                throw new LogicException("Multiple objects found with the id " . $id);
            }
            $object = $this->mapDto(
                $object_
            );
        }

        return $object;
    }


    public function getObjectByImportId(string $import_id) : ?ObjectDto
    {
        $object = null;
        while (($object_ = $this->database->fetchAssoc($result ??= $this->database->query($this->getObjectQuery(
                null,
                null,
                $import_id
            )))) !== null) {
            if ($object !== null) {
                throw new LogicException("Multiple objects found with the import id " . $import_id);
            }
            $object = $this->mapDto(
                $object_
            );
        }

        return $object;
    }


    public function getObjectByRefId(int $ref_id) : ?ObjectDto
    {
        $object = null;
        while (($object_ = $this->database->fetchAssoc($result ??= $this->database->query($this->getObjectQuery(
                null,
                null,
                null,
                $ref_id
            )))) !== null) {
            if ($object !== null) {
                throw new LogicException("Multiple objects found with the ref id " . $ref_id);
            }
            $object = $this->mapDto(
                $object_
            );
        }

        return $object;
    }
}