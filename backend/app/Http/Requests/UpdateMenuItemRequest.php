<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('prices') && is_string($this->prices)) {
            $decoded = json_decode($this->prices, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->merge(['prices' => $decoded]);
            }
        }

        if ($this->has('prices') && is_array($this->prices)) {
            $prices = $this->prices;
            foreach ($prices as $i => $p) {
                $name = trim($p['name'] ?? '');
                if ($name === '') {
                    $rawPrice = (float) ($p['price'] ?? 0);
                    $khr = number_format($rawPrice);
                    $prices[$i]['name'] = "{$khr} ៛";
                }
            }
            $this->merge(['prices' => $prices]);
        }
    }

    public function rules(): array
    {
        return [
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'price' => 'nullable|numeric|min:0|max:99999999',
            'currency' => 'nullable|string',
            'prices' => 'nullable|array',
            'prices.*.id' => 'nullable|integer',
            'prices.*.name' => 'nullable|string|max:100',
            'prices.*.price' => 'required_with:prices|numeric|min:0|max:99999999',
            'prices.*.currency' => 'nullable|string',
            'prices.*.is_default' => 'nullable|boolean',
            'prices.*.sort_order' => 'nullable|integer',
            'image' => 'nullable|string|max:2048',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:5120',
            'type' => 'sometimes|required|in:food,drink,dessert,other',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }
}
