<?php

namespace App\Http\Resources;

use App\Support\ImageStorage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $pricesCollection = $this->relationLoaded('prices') ? $this->prices : collect();
        $hasMultiplePrices = $pricesCollection->count() > 1;

        $minPrice = $pricesCollection->isNotEmpty()
            ? (float) $pricesCollection->min('price')
            : (float) $this->price;

        $maxPrice = $pricesCollection->isNotEmpty()
            ? (float) $pricesCollection->max('price')
            : (float) $this->price;

        if ($hasMultiplePrices && $minPrice !== $maxPrice) {
            $formattedPriceRangeKhr = number_format($minPrice) . ' ៛ - ' . number_format($maxPrice) . ' ៛';
        } else {
            $formattedPriceRangeKhr = number_format((float) $this->price) . ' ៛';
        }

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category_name' => $this->category?->name,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'price_khr' => (int) $this->price,
            'formatted_price_khr' => number_format((float) $this->price) . ' ៛',
            'has_multiple_prices' => $hasMultiplePrices,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'formatted_price_range_khr' => $formattedPriceRangeKhr,
            'prices' => MenuItemPriceResource::collection($pricesCollection),
            'image' => ImageStorage::url($this->image),
            'type' => $this->type,
            'is_available' => (bool) $this->is_available,
            'is_featured' => (bool) $this->is_featured,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
