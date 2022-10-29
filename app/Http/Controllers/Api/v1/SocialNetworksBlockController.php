<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialNetworksBlock\SocialNetworksBlockResource;
use App\Models\SocialNetworksBlock;

class SocialNetworksBlockController extends Controller
{
    public function index() {
        return new SocialNetworksBlockResource(SocialNetworksBlock::first());
    }

    /*public function showDefinite( Request $request ) {
        $socialNetworksBlock = SocialNetworksBlock::whereHas('institute', function ( Builder $query ) use ( $request ) {
            return $query->where('abbreviation', $request->input('institute'));
        })->get();

        return new SocialNetworksBlockResource($socialNetworksBlock);
    }*/

    /*    public function create() {
        }

        public function store( Request $request ) {
        }

        public function show( SocialNetworksBlock $socialNetwork ) {
        }

        public function edit( SocialNetworksBlock $socialNetwork ) {
        }

        public function update( Request $request, SocialNetworksBlock $socialNetwork ) {
        }

        public function destroy( SocialNetworksBlock $socialNetwork ) {
        }*/
}
