<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionVerifyRequest;
use App\Http\Resources\GroupedUserAnswerResource;
use App\Http\Services\QuestionService;
use App\Models\Question;
use App\Models\QuestionAnswer;

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
            'success' => true,
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
            'success' => true,
            'result' => $question
        ]);
    }

    /**
     * @OA\Get (
     *      path="/api/questions/{question_uuid}/answers",
     *      operationId="Get my asnwer to exact question item",
     *      tags={"Questions"},
     *      summary=" Get current user asnwer to exact question item",
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
    public function getQuestionMyAnswers(Question $question)
    {
        $result = $this->questionService->getUserAnswersOnQuestion($question->uuid);
        return response()->json(GroupedUserAnswerResource::collection($result));
    }

    /**
     * @OA\Get (
     *      path="/api/questions/answers",
     *      operationId="Question Answer",
     *      tags={"Questions"},
     *      summary=" Get current user all answers",
     *      description="Returns array",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Answer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *   )
     */
    public function getMyAnswers()
    {
        $result = $this->questionService->getUserAnswers();
        return response()->json(GroupedUserAnswerResource::collection($result));
    }

    /**
     * @OA\Post(
     *      path="/api/questions/{question_uuid}/answer",
     *      operationId="Answer to question",
     *      tags={"Questions"},
     *      summary="Send request to answer the question",
     *      description="Returns message",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"answer_uuid","files"},
     *                 @OA\Property(
     *                     property="answer_uuid",
     *                     type="string",
     *                     example=""
     *                 ),
     *                 @OA\Property(
     *                     property="files",
     *                     type="file",
     *                     example="",
     *                 )
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="true",
     *                  description="success",
     *                  property="success"
     *              ),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  format="boolean",
     *                  default="false",
     *                  description="success",
     *                  property="success"
     *              ),
     *              @OA\Property(
     *                  format="string",
     *                  default="Something went wrong. Please try again.",
     *                  description="error",
     *                  property="error"
     *              ),
     *          ),
     *      )
     *  )
     */
    public function answerToQuestion(QuestionVerifyRequest $request, Question $question)
    {
        $verifiedData = $request->validated();
        $verifiedData['question_uuid'] = $question->uuid;

        $result = $this->questionService->answerQuestion($verifiedData);
        if ($result) {
            return response()->json([
                'success' => true,
                'result' => $result,
                'message' => 'We received your answer.'
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Something went wrong. Please try again.'
        ]);
    }

}
