<?php

namespace Fluxlabs\FluxIliasRestApi\Adapter\Route\Object\MoveObject;

use Fluxlabs\FluxIliasRestApi\Adapter\Api\Api;
use Fluxlabs\FluxRestApi\Body\JsonBodyDto;
use Fluxlabs\FluxRestApi\Body\TextBodyDto;
use Fluxlabs\FluxRestApi\Method\Method;
use Fluxlabs\FluxRestApi\Request\RequestDto;
use Fluxlabs\FluxRestApi\Response\ResponseDto;
use Fluxlabs\FluxRestApi\Route\Route;
use Fluxlabs\FluxRestApi\Status\Status;

class MoveObjectByIdToIdRoute implements Route
{

    private Api $api;


    public static function new(Api $api) : /*static*/ self
    {
        $route = new static();

        $route->api = $api;

        return $route;
    }


    public function getDocuRequestBodyTypes() : ?array
    {
        return null;
    }


    public function getDocuRequestQueryParams() : ?array
    {
        return null;
    }


    public function getMethod() : string
    {
        return Method::PUT;
    }


    public function getRoute() : string
    {
        return "/object/by-id/{id}/move/to-id/{new_parent_id}";
    }


    public function handle(RequestDto $request) : ?ResponseDto
    {
        $id = $this->api->moveObjectByIdToId(
            $request->getParam(
                "id"
            ),
            $request->getParam(
                "new_parent_id"
            )
        );

        if ($id !== null) {
            return ResponseDto::new(
                JsonBodyDto::new(
                    $id
                )
            );
        } else {
            return ResponseDto::new(
                TextBodyDto::new(
                    "Object not found"
                ),
                Status::_404
            );
        }
    }
}