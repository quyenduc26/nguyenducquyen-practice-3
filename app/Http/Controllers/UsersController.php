<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->users = new Users;
    }
    private $users;
 /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *      @OA\Response(response=200, description="All Users" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $users = $this->users->getAllUser();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a new user",
 *     description="Create a new user with the provided username, email, and password",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="john_doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *    @OA\Response(response=200, description="Create New User" ),
*     @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
 * )
 */
    public function store(Request $request)
    {
        $dataInsert = [
            'name' => $request->name,
            'email' =>$request->email,
            'password' =>$request->password,
        ];
        $this->users->createUser($dataInsert);
        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    /**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     summary="Get a specific user",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to retrieve",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="User Detail" ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function show(Request $request, string $id)
    {
        try {
            $user = $this->users->getOneUser($id);
            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

      /**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     summary="Update a specific user",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="User ID",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                  @OA\Property(property="name", type="string", example="john_doe"),
 *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *             )
 *         )
 *     ),
 *      @OA\Response(response=200, description="Update user" ),
*      @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
 *     security={{"bearerAuth":{}}}
 * )
 */
    public function update(Request $request, string $id)
    {
        $post = $this->users->getOneUser($id);
        $dataUpdate = [
            'name' => $request->name,
            'email' =>$request->email,
            'password' =>$request->password,
        ];
        if (!$post) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $this->users->updateUser($dataUpdate, $id);
        return response()->json(['message' => 'User updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */

     /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a specific user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Delate user" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy(string $id)
    {
        $user = $this->users->getOneUser($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $this->users->deleteUser($id);
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
