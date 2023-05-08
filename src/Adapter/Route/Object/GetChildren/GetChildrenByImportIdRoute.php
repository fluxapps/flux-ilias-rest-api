<?php

namespace FluxIliasRestApi\Adapter\Route\Object\GetChildren;

use FluxIliasRestApi\Adapter\Api\IliasRestApi;
use FluxIliasRestApi\Adapter\Object\CustomObjectType;
use FluxIliasRestApi\Adapter\Object\ObjectDto;
use FluxIliasRestApi\Adapter\Object\ObjectType;
use FluxRestApi\Adapter\Body\JsonBodyDto;
use FluxRestApi\Adapter\Body\TextBodyDto;
use FluxRestApi\Adapter\Body\Type\DefaultBodyType;
use FluxRestApi\Adapter\Method\DefaultMethod;
use FluxRestApi\Adapter\Method\Method;
use FluxRestApi\Adapter\Route\Documentation\RouteDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteParamDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteResponseDocumentationDto;
use FluxRestApi\Adapter\Route\Route;
use FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxRestApi\Adapter\Server\ServerResponseDto;
use FluxRestApi\Adapter\Status\DefaultStatus;

class GetChildrenByImportIdRoute implements Route
{

    private function __construct(
        private readonly IliasRestApi $ilias_rest_api
    ) {

    }


    public static function new(
        IliasRestApi $ilias_rest_api
    ) : static {
        return new static(
            $ilias_rest_api
        );
    }


    public function getDocumentation() : ?RouteDocumentationDto
    {
        return RouteDocumentationDto::new(
            $this->getRoute(),
            $this->getMethod(),
            "Get children of object by import id",
            null,
            [
                RouteParamDocumentationDto::new(
                    "import_id",
                    "string",
                    "Object import id"
                )
            ],
            [
                RouteParamDocumentationDto::new(
                    "id",
                    "int",
                    "Filter object to id"
                ),
                RouteParamDocumentationDto::new(
                    "import_id",
                    "string",
                    "Filter object to import id"
                ),
                RouteParamDocumentationDto::new(
                    "ref_id",
                    "int",
                    "Filter object to ref id"
                ),
                RouteParamDocumentationDto::new(
                    "types",
                    ObjectType::class . "[]",
                    "Filter by object types split by ,"
                ),
                RouteParamDocumentationDto::new(
                    "title",
                    "string",
                    "Filter by title"
                ),
                RouteParamDocumentationDto::new(
                    "ref_ids",
                    "bool",
                    "Include ref ids"
                )
            ],
            null,
            [
                RouteResponseDocumentationDto::new(
                    DefaultBodyType::JSON,
                    null,
                    ObjectDto::class . "[]",
                    "Objects"
                ),
                RouteResponseDocumentationDto::new(
                    DefaultBodyType::TEXT,
                    DefaultStatus::_404,
                    null,
                    "Object not found"
                )
            ]
        );
    }


    public function getMethod() : Method
    {
        return DefaultMethod::GET;
    }


    public function getRoute() : string
    {
        return "/object/children/by-import-id/{import_id}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        $children = $this->ilias_rest_api->getChildrenByImportId(
            $request->getParam(
                "import_id"
            ),
            $request->getQueryParam(
                "id"
            ),
            $request->getQueryParam(
                "import_id"
            ),
            $request->getQueryParam(
                "ref_id"
            ),
            ($types = $request->getQueryParam(
                "types"
            )) !== null ? array_map(fn(string $type) : ObjectType => CustomObjectType::factory(
                $type
            ), explode(",", $types)) : null,
            $request->getQueryParam(
                "title"
            ),
            $request->getQueryParam(
                "ref_ids"
            ) === "true",
            false
        );

        if ($children !== null) {
            return ServerResponseDto::new(
                JsonBodyDto::new(
                    $children
                )
            );
        } else {
            return ServerResponseDto::new(
                TextBodyDto::new(
                    "Object not found"
                ),
                DefaultStatus::_404
            );
        }
    }
}
