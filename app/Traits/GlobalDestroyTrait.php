<?php

namespace App\Traits;

trait GlobalDestroyTrait
{
    /**
     * Delete a resource and return JSON for AJAX or redirect for traditional requests
     * 
     * @param $id - The ID of the resource to delete
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::find($id);

        if (!$model) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => __('messages.type_not_found', ['type' => $this->getModelTranslationName()]),
                ], 404);
            }
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => $this->getModelTranslationName()]));
        }

        // Check authorization
        $this->authorize('delete', $model);

        // Delete the model
        // $model->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('messages.type_deleted', ['type' => $this->getModelTranslationName()]),
            ], 200);
        }

        return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => $this->getModelTranslationName()]));
    }

    /**
     * Permanently delete a resource and return JSON for AJAX or redirect for traditional requests
     * 
     * @param $id - The ID of the resource to force delete
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function forceDestroy($id)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::withTrashed()->find($id);

        if (!$model) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => __('messages.type_not_found', ['type' => $this->getModelTranslationName()]),
                ], 404);
            }
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => $this->getModelTranslationName()]));
        }

        // Check authorization
        $this->authorize('forceDelete', $model);

        // Permanently delete the model
        // $model->forceDelete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('messages.type_deleted', ['type' => $this->getModelTranslationName()]),
            ], 200);
        }

        return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => $this->getModelTranslationName()]));
    }

    /**
     * Get the model class from the controller's modelClass property
     * or derive it from the controller name
     * 
     * @return string - Full namespace of the model class
     */
    protected function getModelClass()
    {
        // If modelClass property is set, use it
        if (property_exists($this, 'modelClass') && $this->modelClass) {
            return $this->modelClass;
        }

        // Otherwise, derive from controller name
        // e.g., LineWorkController -> LineWork
        $controllerName = class_basename(static::class);
        $modelName = str_replace('Controller', '', $controllerName);
        return "App\\Models\\{$modelName}";
    }

    /**
     * Get the model translation name for messages
     * Converts CamelCase to snake_case
     * e.g., LineWork -> line_work, Client -> client
     * 
     * @return string - Translated model name
     */
    protected function getModelTranslationName()
    {
        $modelClass = $this->getModelClass();
        $modelName = class_basename($modelClass);

        // Convert CamelCase to snake_case
        $key = preg_replace('/([a-z])([A-Z])/', '$1_$2', $modelName);
        $key = strtolower($key);

        return __('main.' . $key);
    }
}
