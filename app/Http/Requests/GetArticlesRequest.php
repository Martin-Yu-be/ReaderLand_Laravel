<?php

namespace App\Http\Requests;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
 

class GetArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $categories = Category::select(['category'])->get()->toArray();
        $categories = array_map(fn($item) => $item['category'], $categories);

        return [
            'lastArticleId' => 'integer',
            'category' => [Rule::in($categories)],
        ];
    }
}
