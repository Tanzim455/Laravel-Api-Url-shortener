<?php

namespace App\Http\Controllers;

use App\Http\Resources\UrlVisitCollection;
use App\Models\Url;
use App\Models\UrlVisit;
use Illuminate\Pagination\LengthAwarePaginator;

class UrlVisitController extends Controller
{
    public function index()
    {

        $user_url_exists = UrlVisit::where('user_id', auth()->user()->id)->exists();
        $auth_user_url_exists=Url::where('user_id',auth()->user()->id)->exists();
        //Check if the authenticated users url has any visits
        if ( $user_url_exists) {
            $urlVisits = UrlVisit::where('user_id', auth()->user()->id)->paginate(10);

            $shortUrls = Url::where('user_id', auth()->user()->id)->pluck('short_url');
            $urlVisitsShortUrls = $urlVisits->pluck('short_url');
            $arrayDiff = $shortUrls->diff($urlVisitsShortUrls);

            $mappedArray = $arrayDiff->map(function ($shortUrl) {
                return (object) [
                    'short_url' => $shortUrl,
                    'visits' => 0,
                ];
            });

            $perPage = 10;
            $currentPage = LengthAwarePaginator::resolveCurrentPage('page');
            $items = $mappedArray->slice(($currentPage - 1) * $perPage, $perPage);

            $paginatedMappedArray = new LengthAwarePaginator(
                $items,
                $mappedArray->count(),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );

            // Convert the $urlVisits collection to the same structure as $mappedArray
            $convertedUrlVisits = $urlVisits->map(function ($urlVisit) {
                return (object) [
                    'short_url' => $urlVisit->short_url,
                    'visits' => $urlVisit->visits,
                ];
            });

            // Concatenate the collections based on whether there are URLs without visits
            $mergedCollection = $arrayDiff->isEmpty()
                ? $convertedUrlVisits
                : $convertedUrlVisits->concat($paginatedMappedArray);

            return [
                'all_urls' => new UrlVisitCollection($mergedCollection),
            ];

        }
        //Check if the authenticated users has url but not any visits
       if($auth_user_url_exists && !$user_url_exists){
        $auth_user_url = Url::where('user_id', auth()->user()->id)->pluck('short_url');

        // Paginate the $auth_user_url collection
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage('page');
        $items = $auth_user_url->slice(($currentPage - 1) * $perPage, $perPage);

        $paginatedAuthUserUrls = new LengthAwarePaginator(
            $items,
            $auth_user_url->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Transform the paginated collection items
        $mappedArray = $paginatedAuthUserUrls->map(function ($shortUrl) {
            return (object) [
                'short_url' => $shortUrl,
                'visits' => 0,
            ];
        });

        return [
            'auth_user_urls' => new UrlVisitCollection($mappedArray),
        ];
       }
        return [
            'message' => 'Sorry you dont have any Urls here',
        ];
    }
}
