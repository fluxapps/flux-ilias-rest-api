<?php

namespace FluxIliasRestApi\Adapter\Route\CourseMember\AddCourseMember;

use FluxIliasRestApi\Adapter\Api\Api;
use FluxIliasRestApi\Adapter\Api\CourseMember\CourseMemberDiffDto;
use FluxRestApi\Body\JsonBodyDto;
use FluxRestApi\Body\TextBodyDto;
use FluxRestApi\Request\RequestDto;
use FluxRestApi\Response\ResponseDto;
use FluxRestApi\Route\Route;
use FluxRestBaseApi\Body\BodyType;
use FluxRestBaseApi\Method\Method;
use FluxRestBaseApi\Status\Status;

class AddCourseMemberByIdByUserIdRoute implements Route
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
        return [
            BodyType::JSON
        ];
    }


    public function getDocuRequestQueryParams() : ?array
    {
        return null;
    }


    public function getMethod() : string
    {
        return Method::POST;
    }


    public function getRoute() : string
    {
        return "/course/by-id/{id}/add-member/by-id/{user_id}";
    }


    public function handle(RequestDto $request) : ?ResponseDto
    {
        if (!($request->getParsedBody() instanceof JsonBodyDto)) {
            return ResponseDto::new(
                TextBodyDto::new(
                    "No json body"
                ),
                Status::_400
            );
        }

        $id = $this->api->addCourseMemberByIdByUserId(
            $request->getParam(
                "id"
            ),
            $request->getParam(
                "user_id"
            ),
            CourseMemberDiffDto::newFromData(
                $request->getParsedBody()->getData()
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
                    "Course member not found"
                ),
                Status::_404
            );
        }
    }
}
