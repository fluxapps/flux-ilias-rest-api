<?php

namespace Fluxlabs\FluxIliasRestApi\Channel\Course\Command;

use Fluxlabs\FluxIliasRestApi\Adapter\Api\Course\CourseDiffDto;
use Fluxlabs\FluxIliasRestApi\Adapter\Api\Object\ObjectDto;
use Fluxlabs\FluxIliasRestApi\Adapter\Api\Object\ObjectIdDto;
use Fluxlabs\FluxIliasRestApi\Channel\Course\CourseQuery;
use Fluxlabs\FluxIliasRestApi\Channel\Object\Port\ObjectService;

class CreateCourseCommand
{

    use CourseQuery;

    private ObjectService $object;


    public static function new(ObjectService $object) : /*static*/ self
    {
        $command = new static();

        $command->object = $object;

        return $command;
    }


    public function createCourseToId(int $parent_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createCourse(
            $this->object->getObjectById(
                $parent_id
            ),
            $diff
        );
    }


    public function createCourseToImportId(string $parent_import_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createCourse(
            $this->object->getObjectByImportId(
                $parent_import_id
            ),
            $diff
        );
    }


    public function createCourseToRefId(int $parent_ref_id, CourseDiffDto $diff) : ?ObjectIdDto
    {
        return $this->createCourse(
            $this->object->getObjectByRefId(
                $parent_ref_id
            ),
            $diff
        );
    }


    private function createCourse(?ObjectDto $parent_object, CourseDiffDto $diff) : ?ObjectIdDto
    {
        if ($parent_object === null) {
            return null;
        }

        $ilias_course = $this->newIliasCourse();

        $ilias_course->setTitle("");

        $ilias_course->create();
        $ilias_course->createReference();
        $ilias_course->putInTree($parent_object->getRefId());

        $this->mapDiff(
            $diff,
            $ilias_course
        );

        $ilias_course->update();

        return ObjectIdDto::new(
            $ilias_course->getId() ?: null,
            $diff->getImportId(),
            $ilias_course->getRefId() ?: null
        );
    }
}