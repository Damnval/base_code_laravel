<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Initialize Service to use
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="GetUser",
     *      tags={"users"},
     *      summary="Get list of Users",
     *      description="Returns list of Songs",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="array",
     *                example={{
     *                  "id": 1,
     *                  "name": "Kristine",
     *                  "email": "kristine@gmail.com",
     *                  "address": {
     *                      "address": "Cebu"
     *                   }
     *                }, {
     *                  "id": 2,
     *                  "name": "John Doe",
     *                  "email": "john@gmail.com",
     *                  "address": null
     *                }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="John Doe"
     *                      ),
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="address",
     *                         type="object",
     *                         example=""
     *                      ),
     *                ),
     *             ),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      )
     * )
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return new UserCollection($users);
    }

    /**
     * @OA\Post(
     *       path="/api/users",
     *       operationId="StoreUser",
     *       tags={"users"},
     *       summary="Store User",
     *       description="Will save a new user in DB",
     *       @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *               mediaType="multipart/form-data",
     *               @OA\Schema(
     *                  type="object",
     *                  required={"address[address]","name", "email", "password"},
     *                  @OA\Property(property="name", type="text"),
     *                  @OA\Property(property="email", type="text"),
     *                  @OA\Property(property="password", type="password"),
     *                  @OA\Property(property="address[address]", type="text"),
     *               ),
     *           ),
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Register Successfully",
     *          @OA\JsonContent(
     *                @OA\Property(property="data", type="object",
     *                   @OA\Property(property="id", type="text", example=1),
     *                   @OA\Property(property="name", type="text", example="Joe Doe"),
     *                   @OA\Property(property="email", type="text", example="joe@gmail.com"),
     *                   @OA\Property(
     *                   property="address",
     *                   type="object",
     *                   @OA\Property(property="id", type="text", example=1),
     *                       @OA\Property(property="address", type="text", example="cebu")
     *                   ),
     *              ),
     *           )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     *
     */
    public function store(UserStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            // Will return only validated data
            $validated = $request->validated();
            $user = $this->userService->storeUser($validated);
        } catch (Exception $e) {
            DB::rollBack();
            return 'error: ' . $e->getMessage();
        }

        DB::commit();
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
    * @OA\Get(
    *      path="/api/users/{id}",
    *      operationId="ShowUser",
    *      tags={"users"},
    *      summary="Get User",
    *      description="Returns user data",
    *      @OA\Parameter(
    *          name="id",
    *          description="User id",
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(
    *                @OA\Property(property="data", type="object",
    *                   @OA\Property(property="id", type="text", example=1),
    *                   @OA\Property(property="name", type="text", example="Joe Doe"),
    *                   @OA\Property(property="email", type="text", example="joe@gmail.com"),
    *                   @OA\Property(
    *                   property="address",
    *                   type="object",
    *                   @OA\Property(property="id", type="text", example=1),
    *                       @OA\Property(property="address", type="text", example="cebu")
    *                   ),
    *              ),
    *           )
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Bad Request"
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      )
    * )
    */
    public function show($id)
    {
        $user = $this->userService->getUser($id);

        return new UserResource($user);
    }

    /**
     * @OA\Put(
     *       path="/api/users/{id}",
     *       operationId="UpdateUser",
     *       tags={"users"},
     *       summary="Updat User",
     *       description="Will save a new user in DB",
     *       @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *       ),
     *       @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(
     *                  type="object",
     *                  required={"address[address]","name", "email", "password"},
     *                  @OA\Property(property="name", type="text", example="Update Sample Name"),
     *                  @OA\Property(property="email", type="text", example="update@gmail.com"),
     *                  @OA\Property(property="password", type="password", example="password"),
     *                   @OA\Property(
     *                   property="address",
     *                   type="object",
     *                   @OA\Property(property="id", type="text", example=1),
     *                       @OA\Property(property="address", type="text", example="cebu")
     *                   ),
     *               ),
     *           ),
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Update Successfully",
     *          @OA\JsonContent(
     *                @OA\Property(property="data", type="object",
     *                   @OA\Property(property="id", type="text", example=1),
     *                   @OA\Property(property="name", type="text", example="Joe Doe"),
     *                   @OA\Property(property="email", type="text", example="joe@gmail.com"),
     *                   @OA\Property(
     *                   property="address",
     *                   type="object",
     *                   @OA\Property(property="id", type="text", example=1),
     *                       @OA\Property(property="address", type="text", example="cebu")
     *                   ),
     *              ),
     *           )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(UserUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $user = $this->userService->updateUser($validated, $id);
        } catch (Exception $e) {
            DB::rollBack();
            return 'error: ' . $e->getMessage();
        }

        DB::commit();
        return new UserResource($user);
    }

    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      operationId="deleteSong",
     *      tags={"users"},
     *      summary="Delete existing user",
     *      description="Deletes a user record and returns a success message",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="text", example="Data deleted successfully!"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->userService->deleteUser($id);
        } catch (Exception $e) {
            DB::rollBack();
            return 'error: ' . $e->getMessage();
        }

        DB::commit();

        return response()->json([
            'message' => 'Data deleted successfully!'
        ]);
    }
}
