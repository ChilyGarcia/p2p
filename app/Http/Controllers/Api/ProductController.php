<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @group Product Management
 *
 * APIs para la gestión de productos
 */
class ProductController extends Controller
{
    /**
     * Lista de productos
     * 
     * Devuelve una lista paginada de todos los productos.
     *
     * @queryParam page int Número de página. Example: 1
     * @queryParam per_page int Resultados por página (default: 15). Example: 15
     * 
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Producto 1",
     *       "description": "Descripción del producto 1",
     *       "price": 19.99,
     *       "created_at": "2023-01-01T12:00:00.000000Z",
     *       "updated_at": "2023-01-01T12:00:00.000000Z"
     *     }
     *   ],
     *   "links": {
     *     "first": "http://example.com/api/products?page=1",
     *     "last": "http://example.com/api/products?page=1",
     *     "prev": null,
     *     "next": null
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 1,
     *     "path": "http://example.com/api/products",
     *     "per_page": 15,
     *     "to": 1,
     *     "total": 1
     *   }
     * }
     */
    public function index(): JsonResponse
    {
        // Aquí iría tu lógica para obtener productos
        return response()->json([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Producto 1',
                    'description' => 'Descripción del producto 1',
                    'price' => 19.99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ],
            // Añadir paginación aquí
        ]);
    }

    /**
     * Detalles de producto
     * 
     * Devuelve la información detallada de un producto específico.
     *
     * @urlParam id int required ID del producto. Example: 1
     * 
     * @response {
     *   "data": {
     *     "id": 1,
     *     "name": "Producto 1",
     *     "description": "Descripción del producto 1",
     *     "price": 19.99,
     *     "created_at": "2023-01-01T12:00:00.000000Z",
     *     "updated_at": "2023-01-01T12:00:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "message": "Producto no encontrado"
     * }
     */
    public function show(int $id): JsonResponse
    {
        // Aquí iría tu lógica para obtener un producto específico
        return response()->json([
            'data' => [
                'id' => $id,
                'name' => 'Producto 1',
                'description' => 'Descripción del producto 1',
                'price' => 19.99,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
