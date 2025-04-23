<?php

namespace App\Http\Controllers;

use App\Http\Services\QuestionService;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * @OA\Get (
     *      path="/api/questions/",
     *      operationId="getQuestionsList",
     *      tags={"Questions"},
     *      summary="Get the list of possible questions with their answers",
     *      description="Returns an array of questions with answers",
     *      @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Bearer token",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *      ),
     *      @OA\Parameter(
     *         name="Content-Type",
     *         in="header",
     *         description="Request body format",
     *         required=true,
     *        @OA\Schema(type="string", default="application/json")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Question")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function index()
    {
        $list = $this->questionService->questionList();
        return response()->json([
            'result' => $list
        ]);
    }

    /**
     * @OA\Get (
     *      path="/api/questions/{question_uuid}",
     *      operationId="Question item",
     *      tags={"Questions"},
     *      summary=" Get the single quations with its's answers",
     *      description="Returns array",
     *      @OA\Parameter(
     *          in="path",
     *          name="question_uuid",
     *          description="Question UUId",
     *          @OA\Schema(
     *              type="string",
     *              default="",
     *          )
     *      ),
     *      @OA\Parameter(
     *         name="Authorization: Bearer",
     *         in="header",
     *         description="Authorization: Bearer",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *      ),
     *      @OA\Parameter(
     *         name="Content-Type",
     *         in="header",
     *         description="Request body format",
     *         required=true,
     *        @OA\Schema(type="string", default="application/json")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Question",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *   )
     */

    public function getQuestion(Question $question)
    {
        $question->load('answers');
        return response()->json([
            'result' => $question
        ]);
    }

    public function updateQuestionAnswer(QuestionAnswer $questionAnswer)
    {
    }

    public function answerToQuestion(Request $request)
    {
    }
}
