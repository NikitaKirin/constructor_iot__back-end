<?php

Route::as('headHunter')->group(function () {

    Route::get('headhunter/vacancies/info', function () {
        $totalVacanciesCount = \Illuminate\Support\Facades\DB::table('professions')
            ->sum('vacancies_count');
        $areaVacanciesCount = \Illuminate\Support\Facades\DB::table('professions')
            ->sum('area_vacancies_count');

        return response()->json([
            'totalCount' => $totalVacanciesCount,
            'areaCount'  => $areaVacanciesCount,
        ]);
    })->name('.info');

});
