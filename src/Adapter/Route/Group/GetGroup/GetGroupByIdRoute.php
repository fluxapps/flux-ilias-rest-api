<?php

namespace Fluxlabs\FluxIliasRestApi\Adapter\Route\Group\GetGroup;

use Fluxlabs\FluxIliasRestApi\Adapter\Api\Api;
use Fluxlabs\FluxRestApi\Body\JsonBodyDto;
use Fluxlabs\FluxRestApi\Body\TextBodyDto;
use Fluxlabs\FluxRestApi\Method\Method;
use Fluxlabs\FluxRestApi\Request\RequestDto;
use Fluxlabs\FluxRestApi\Response\ResponseDto;
use Fluxlabs\FluxRestApi\Route\Route;
use Fluxlabs\FluxRestApi\Status\Status;

class GetGroupByIdRoute implements Route
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
        return Method::GET;
    }


    public function getRoute() : string
    {
        return "/group/by-id/{id}";
    }


    public function handle(RequestDto $request) : ?ResponseDto
    {
        $group = $this->api->getGroupById(
            $request->getParam(
                "id"
            )
        );

        if ($group !== null) {
            return ResponseDto::new(
                JsonBodyDto::new(
                    $group
                )
            );
        } else {
            return ResponseDto::new(
                TextBodyDto::new(
                    "Group not found"
                ),
                Status::_404
            );
        }
    }
}
