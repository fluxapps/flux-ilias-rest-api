<?php

namespace Fluxlabs\FluxIliasRestApi\Adapter\Route\CourseMember\AddCourseMember;

use Fluxlabs\FluxIliasRestApi\Adapter\Api\Api;
use Fluxlabs\FluxIliasRestApi\Adapter\Api\CourseMember\MemberDiffDto;
use Fluxlabs\FluxRestApi\Body\JsonBodyDto;
use Fluxlabs\FluxRestApi\Body\TextBodyDto;
use Fluxlabs\FluxRestApi\Method\Method;
use Fluxlabs\FluxRestApi\Request\RequestDto;
use Fluxlabs\FluxRestApi\Response\ResponseDto;
use Fluxlabs\FluxRestApi\Route\Route;
use Fluxlabs\FluxRestApi\Status\Status;

class AddCourseMemberByRefIdByUserImportIdRoute implements Route
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
        return Method::POST;
    }


    public function getRoute() : string
    {
        return "/course/by-ref-id/{ref_id}/member/add/by-import-id/{user_import_id}";
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

        $id = $this->api->addCourseMemberByRefIdByUserImportId(
            $request->getParam(
                "ref_id"
            ),
            $request->getParam(
                "user_import_id"
            ),
            MemberDiffDto::newFromData(
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
                    "Member not found"
                ),
                Status::_404
            );
        }
    }
}
