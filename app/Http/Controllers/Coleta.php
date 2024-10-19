<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportException;
use App\Imports\SpreadsheetImport;
use App\Jobs\ImportSheetJob;
use App\Models\Job;
use App\Models\Upload;
use Exception;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class Coleta extends Controller
{
    public function index(): Response
    {
        $job = Job::where('queue', '=', 'import_sheets')->first();
        $year_import = Upload::query()->max('ano') ? Upload::query()->max('ano') + 1 : (int) env('YEAR_INITIAL');
        return Inertia::render('Coleta/Index', ['year_import' => $year_import, 'jobs' => $job]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {

            $year_current = Upload::query()->max('ano');
            $infor = 'Planilha importada com sucesso: \n';
            if ((int) $request->year <= $year_current) {
                throw new Exception('Já existe uma planilha correspondente a esse ano no sistema');
            }

            $year_current = (int) $request->year;

            if ($request->hasFile('sheetsAll') && $request->file('sheetsAll')->isValid()) {
                $file = $request->file('sheetsAll');
                $file_name = $file->getClientOriginalName();
                $file_path = $request->file('sheetsAll')->storeAs('file/sheetsForJob', $file_name);
                ImportSheetJob::dispatch($file_path, Upload::ALL_DATATABLE, $year_current);
//                $upload = $this->import_file($file, Upload::ALL_DATATABLE, $year_current);
//                $infor = $infor.$upload->result;
            }
            if ($request->hasFile('sheetsTeste') && $request->file('sheetsTeste')->isValid()) {
                $file = $request->file('sheetsTeste');
                $upload2 = $this->import_file($file, Upload::DEVELOP_TESTE, $year_current);
                $infor = $infor . $upload2->result;
            }
            return back()->with('success', "Planilha em processamento");
        } catch (Exception $e) {
            //            dd($e, $e->getMessage());
            return back()->with('fail', $e->getMessage());
        }
    }

    public function importProgress(Request $request)
    {
        $job = Job::query()->orderBy('id', 'desc')->get();
        $job = $job->map(function ($item) {
            $command = unserialize(json_decode($item->payload)->data->command);
            $sheet = new File(Storage::path($command->getFilePath()));
            $status = Cache::get('year_import') == $sheet->getFilename();
            return [
                "id" => $item->id,
                "ano" => '',
                "name" => $sheet->getFilename(),
                "status" => $status
            ];
        });
        return response($job);
    }

    /**
     * @throws ImportException
     */
    private function import_file(UploadedFile $file, int $type, string $year): Upload
    {
        try {
            DB::beginTransaction();
            $sheets_config = Config::get('import.sheets.' . $type);
            $spreadsheet = new SpreadsheetImport($sheets_config, $year, $file, Auth()->user()->id);
            $upload = $spreadsheet->import();
            DB::commit();
        } catch (ImportException $e) {
            DB::rollBack();
            throw $e;
        }
        return $upload;
    }

}
