<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\CrmProjects;
use App\Models\CrmProjectPipeline;
use App\Models\CrmProjectItems;
use App\Models\CrmProjectPaymentMethodSubscription;
use App\Models\CrmProjectPaymentMethodPerpetualLicense;
use App\Models\CrmProjectInvoice;
use App\Models\ProjectProduct;

class PipelineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seed           = CrmProjects::select('crm_projects.*')->where('pipeline_status', 1)->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_projects.updated_at', 'DESC');

        $quotation      = CrmProjects::select('crm_projects.*')->where('pipeline_status', 2)->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_projects.updated_at', 'DESC');
        $negotiation    = CrmProjects::select('crm_projects.*')->where('pipeline_status', 3)->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_projects.updated_at', 'DESC');
        $po             = CrmProjects::select('crm_projects.*')->where('pipeline_status', 4)->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_projects.updated_at', 'DESC');
        $cr             = CrmProjects::select('crm_projects.*')->where('pipeline_status', 5)->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_projects.updated_at', 'DESC');
        $po_done        = CrmProjects::select('crm_projects.*')->where('pipeline_status', 6)->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_projects.updated_at', 'DESC');
        $invoice        = CrmProjectInvoice::select('crm_project_invoice.*')->where('crm_project_invoice.status', '0')->join('crm_projects', 'crm_projects.id','=','crm_project_invoice.crm_project_id')->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_project_invoice.updated_at', 'DESC');
        $payment_receive= CrmProjectInvoice::select('crm_project_invoice.*')->where('crm_project_invoice.status', 1)->join('crm_projects', 'crm_projects.id','=','crm_project_invoice.crm_project_id')->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')->join('crm_product','crm_product.id','=','crm_projects.project_category_id')->orderBy('crm_project_invoice.updated_at', 'DESC');

        if(isset($_GET['search']) and $_GET['search'] != "")
        {
            $seed = $seed->where(function($table){
                         $table->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%');
                        });
            $quotation = $quotation->where(function($table){
                            $table->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                             ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                             ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                             ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%');
                            });
            $negotiation = $negotiation->where(function($table){
                        $table->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%');
                    });
            $po = $po->where(function($table){
                        $table->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%');
                        });
            $cr = $cr->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%')
                         ;
            $po_done = $po_done->where(function($table){
                        $table->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%');
                        });
            $invoice = $invoice->where(function($table){
                        $table->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%');
                        });
            $payment_receive = $payment_receive->where(function($table){
                        $table->where('crm_client.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.pic_name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_projects.name', 'LIKE', '%'. $_GET['search'] .'%')
                         ->orWhere('crm_client.address', 'LIKE', '%'. $_GET['search'] .'%');
                        });
        }

        $params['seed']             = $seed->get();
        $params['quotation']        = $quotation->get(); 
        $params['negotiation']      = $negotiation->get();
        $params['po']               = $po->get();
        $params['cr']               = $cr->get();
        $params['po_done']          = $po_done->get();
        $params['invoice']          = $invoice->get();
        $params['payment_receive']  = $payment_receive->get();

        return view('pipeline.index')->with($params);
    }

    /**
     * Print Invoice
     * @param  $id
     * @return pdf
     */
    public function printInvoice($id)
    {
        $params['data'] = CrmProjectInvoice::where('id', $id)->first();

        $view = view('pipeline.invoice-print')->with($params);        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream();
    }

    /**
     * Store Invoice Perpetula
     * @param  Request $request
     * @return objects
     */
    public function storeInvoicePerpetual(Request $request)
    {
        $data                       = new CrmProjectInvoice();
        $data->crm_project_id       = $request->crm_project_id;
        $data->payment_term         = $request->payment_term;
        $data->invoice_number       = $request->invoice_number;
        $data->date                 = $request->date;
        $data->sub_total            = replace_idr($request->sub_total);
        $data->tax                  = $request->tax;
        $data->tax_price            = replace_idr($request->tax_price);
        $data->total                = replace_idr($request->total);
        $data->remarks              = $request->remarks;
        $data->status               = 0;
        $data->save();

        $perpetual = CrmProjectPaymentMethodPerpetualLicense::where('id', $request->id)->first();
        if($perpetual)
        {
            $perpetual->status                  = 1;
            $perpetual->crm_project_invoice_id  = $data->id;
            $perpetual->save();
        }

        return redirect()->route('pipeline.index');
    }

    /**
     * Store Invoice Pay
     * @param  Request $request
     * @return void
     */
    public function storeInvoicePay(Request $request)
    {
        $invoice = CrmProjectInvoice::where('id', $request->id)->first();
        if($invoice)
        {
            $invoice->date_payment      = $request->date_payment;
            $invoice->total_payment     = replace_idr($request->total_payment);
            $invoice->remarks_payment   = $request->remarks_payment;
            $invoice->status            = 1;
            $invoice->save();            
        }

        return redirect()->route('pipeline.index')->with('message-success', 'Payment Success');
    }

    /**
     * Create
     * @return view
     */
    public function create()
    {
        return view('pipeline.create');
    }

    /**
     * Move To Change Request
     * @return 
     */
    public function moveToPoDone($id)
    {
        $project = CrmProjects::where('id', $id)->first();
        $project->pipeline_status = 6;
        $project->save();

        return redirect()->route('pipeline.index');
    }

    /**
     * Move To Quotation
     * @return 
     */
    public function moveToQuotation($id, Request $request)
    {
        $project                    = CrmProjects::where('id', $id)->first();
        $project->pipeline_status   = 2;
        $project->quotation_order   = $request->quotation_order;
        $project->price             = replace_idr($request->price);

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path('/storage/projects/'. $project->id);
            $file->move($destinationPath, $fileName);

           $project->file = $fileName;
        }

        $project->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 2;
        $item->item                 = 'quotation_order';
        $item->value                = $request->quotation_order;
        $item->save(); 

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 2;
        $item->item                 = 'submit_date';
        $item->value                = $request->submit_date;
        $item->save(); 

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 2;
        $item->item                 = 'price';
        $item->value                = replace_idr($request->price);
        $item->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 2;
        $item->item                 = 'month';
        $item->value                = $request->monthQuo;
        $item->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 2;
        $item->item                 = 'start_date';
        $item->value                = $request->start_date_quo;
        $item->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 2;
        $item->item                 = 'end_date';
        $item->value                = $request->end_date_quo;
        $item->save();


        if (isset($fileName))
        {
            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $project->id;
            $item->status               = 2;
            $item->item                 = 'file';
            $item->value                = $fileName;
            $item->save();
        }

        return redirect()->route('pipeline.index');
    }

    /**
     * Move To Negotation
     * @return 
     */
    public function moveToNegotation($id, Request $request)
    {
        $project = CrmProjects::where('id', $id)->first();
        $project->pipeline_status = 3;
        $project->price             = replace_idr($request->price);

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path('/storage/projects/'. $project->id);
            $file->move($destinationPath, $fileName);

           $project->file = $fileName;
        }

        $project->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 3;
        $item->item                 = 'negotation_order';
        $item->value                = $request->negotation_order;
        $item->save(); 

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 3;
        $item->item                 = 'submit_date';
        $item->value                = $request->submit_date;
        $item->save(); 

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 3;
        $item->item                 = 'price';
        $item->value                = replace_idr($request->price);
        $item->save(); 

        if (isset($fileName))
        {
            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $project->id;
            $item->status               = 3;
            $item->item                 = 'file';
            $item->value                = $fileName;
            $item->save();
        }

        return redirect()->route('pipeline.index');
    }

    /**
     * Move To Quotation
     * @return 
     */
    public function moveToPO($id, Request $request)
    {
        $project = CrmProjects::where('id', $id)->first();
        $project->pipeline_status = 4;
        $project->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 4;
        $item->item                 = 'po_number';
        $item->value                = $request->po_number;
        $item->save(); 

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 4;
        $item->item                 = 'price';
        $item->value                = replace_idr($request->price);
        $item->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 4;
        $item->item                 = 'payment_method';
        $item->value                = $request->payment_method;
        $item->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 4;
        $item->item                 = 'month';
        $item->value                = $request->month;
        $item->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 4;
        $item->item                 = 'start_date';
        $item->value                = $request->start_date;
        $item->save();

        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $project->id;
        $item->status               = 4;
        $item->item                 = 'end_date';
        $item->value                = $request->end_date;
        $item->save();

        // perpetual license
        if($request->payment_method == 1)
        {
            if(isset($request->terms))
            {
                foreach($request->terms as $k => $i)
                {
                    $perpetual                      = new CrmProjectPaymentMethodPerpetualLicense();
                    $perpetual->crm_project_id      = $project->id;
                    $perpetual->terms               = $i;
                    $perpetual->milestone           = $request->milestone[$k];
                    $perpetual->persen              = $request->persen[$k];
                    $perpetual->value               = replace_idr($request->value[$k]);
                    $perpetual->status              = 0;
                    $perpetual->save();
                }
            }
        }

        if($request->payment_method == 2)
        {
            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $project->id;
            $item->status               = 4;
            $item->item                 = 'year';
            $item->value                = $request->year;
            $item->save();

            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $project->id;
            $item->status               = 4;
            $item->item                 = 'subscription_year_or_month';
            $item->value                = $request->subscription_year_or_month;
            $item->save();

            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $project->id;
            $item->status               = 4;
            $item->item                 = 'start_date_subscription';
            $item->value                = $request->start_date_subscription;
            $item->save();

            // if subscribe year
            if($request->subscription_year_or_month==1)
            {
                for($var =0; $var <= $request->year; $var++)
                {
                    $sub                    = new CrmProjectPaymentMethodPerpetualLicense();
                    $sub->crm_project_id    = $project->id; 
                    $sub->term              = $var;
                    $sub->due_date          = date('Y-m-d', strtotime('+ '+ $var +' year', strtotime($request->start_date_subscription)));
                    $sub->status            = 0;
                    $sub->save();
                }
            }
            //if subscribe month
            if($request->subscription_year_or_month==2)
            {
                for($var =0; $var <= $request->year; $var++)
                {
                    $sub                    = new CrmProjectPaymentMethodPerpetualLicense();
                    $sub->crm_project_id    = $project->id; 
                    $sub->term              = $var;
                    $sub->due_date          = date('Y-m-d', strtotime('+ '+ $var +' month', strtotime($request->start_date_subscription)));
                    $sub->status            = 0;
                    $sub->save();
                }
            }
        }

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path('/storage/projects/'. $project->id);
            $file->move($destinationPath, $fileName);

            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $project->id;
            $item->status               = 2;
            $item->item                 = 'file';
            $item->value                = $fileName;
            $item->save();
        }

        return redirect()->route('pipeline.index');
    }

    /**
     * Add Notes
     * @param  $id
     * @return 
     */
    public function addNote($id, Request $request)
    {
        $project = CrmProjects::where('id', $id)->first();

        $data                       = new CrmProjectPipeline();
        $data->user_id              = \Auth::user()->id;
        $data->crm_project_id       = $id;
        $data->status_card          = 5;
        $data->pipeline_status      = $project->pipeline_status; 
        $data->value                = $request->note;
        $data->title                = $request->title;
        $data->date                 = empty($request->date) ? date('Y-m-d') : $request->date;

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path('/storage/projects/'. $project->id);
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }

        $data->save();

        return redirect()->route('pipeline.index');
    }

    /**
     * Update Note
     * @return void
     */
    public function updateNote(Request $request)
    {
        $data                       = CrmProjectPipeline::where('id', $request->id)->first();
        $data->user_id              = \Auth::user()->id;
        $data->status_card          = 5;
        $data->pipeline_status      = $request->pipeline_status; 
        $data->value                = $request->note;
        $data->title                = $request->title;
        $data->date                 = empty($request->date) ? date('Y-m-d') : $request->date;

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path('/storage/projects/'. $project->id);
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }

        $data->save();

        return redirect()->route('pipeline.index');
    }

    /**
     * Update Card
     * @param  Request $request
     * @return void
     */
    public function updateCard(Request $request)
    {
        $data                       = CrmProjects::where('id', $request->id)->first();
        //$data->crm_client_id        = $request->crm_client_id;
        $data->price                = replace_idr($request->price);
        $data->description          = $request->description; 
        $data->color                = $request->color; 
        $data->pipeline_status      = $request->pipeline_status;
        $data->name                 = $request->name;
        $data->project_category     = $request->project_category;
        $data->sales_id             = \Auth::user()->id;

        $data->project_type         = $request->project_type;
        $data->license_number   = $request->license_number;
        $data->durataion         = $request->durataion;

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path('/storage/projects/'. $data->id);
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }
        $data->save();


        if(isset($fileName))
        {
            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $data->id;
            $item->status               = 1;
            $item->item                 = 'file';
            $item->value                = $fileName;
            $item->save();
        }

        //cek data projectproductnya dia sebelumnya trus cek yang di ceklis dia
        
        /*$dataProduct = ProjectProduct::where('crm_project_id',$data->id)->get()->each->delete();
        
        foreach ($request->project_product_id as $key => $value) {
            $val = isset($value) ? 1 : 0;
            # code...
            if($val == 1) {
                $product = new ProjectProduct();
                $product->crm_project_id  = $data->id;
                $product->crm_product_id  = $request->project_product_id[$key];
                if(isset($request->limit_user[$key])){
                    $product->limit_user      = $request->limit_user[$key];
                }
                $product->save();
            }
        }
        */

        if($request->project_product_id != null) {
            ProjectProduct::whereNotIn('crm_product_id',$request->project_product_id)->where('crm_project_id',$data->id)->delete();
            foreach ($request->project_product_id as $key => $value) {
                $product = ProjectProduct::where('crm_product_id',$value)->where('crm_project_id',$data->id)->first();
                if(!$product)
                {
                    $product = new ProjectProduct();
                    $product->crm_project_id  = $data->id;
                    $product->crm_product_id  = $request->project_product_id[$key];
                    if(isset($request->limit_user[$key])){
                        $product->limit_user      = $request->limit_user[$key];
                    }
                    $product->save();
                }
            }
        } else{
            ProjectProduct::where('crm_project_id',$data->id)->delete();
        }
        
        //jika project_id = 1 update ke server
        if($data->project_category_id == 1)
        {
            //send to api
            $dataAPI   = CrmProjects::select('crm_projects.id as project_id','crm_projects.name as project_name','crm_client.name as client_name','crm_projects.user_name','crm_projects.password','project_product.crm_product_id','project_product.limit_user','crm_product.name as modul_name')
            ->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')
            ->join('project_product', 'project_product.crm_project_id','=','crm_projects.id')
            ->join('crm_product','project_product.crm_product_id','=','crm_product.id')
            ->where('crm_projects.id', $data->id);

            $dataSend = clone $dataAPI;

            foreach ($dataSend->get() as $key => $value) {
                # code...
                $ch = curl_init();
                $data = "project_id=$value->project_id&project_name=$value->project_name&client_name=$value->client_name&user_name=$value->user_name&password=$value->password&crm_product_id=$value->crm_product_id&limit_user=$value->limit_user&modul_name=$value->modul_name";

                $url = 'http://api.em-hr.co.id/update-modul-hris';
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                
                $html = curl_exec($ch);

                if (curl_errno($ch)) 
                {
                    print curl_error($ch);
                }
                curl_close($ch);
                //dd($html);
            }
        }
        return redirect()->route('pipeline.index')->with('message-success', 'Card Updated');
    }

    /**
     * Store database Card
     * @return void
     */
    public function store(Request $request)
    {
        if($request->project_category_id == 1) {
            $this->validate($request,[
            'user_name' => 'required|unique:crm_projects',
            'password' => 'required',
            ]);
        }

        $data                       = new CrmProjects();
        $data->crm_client_id        = $request->crm_client_id;
        $data->price                = replace_idr($request->price);
        $data->description          = $request->description; 
        $data->color                = $request->color; 
        $data->pipeline_status      = $request->pipeline_status;
        $data->name                 = $request->name;
        $data->project_category     = $request->project_category;
        $data->project_category_id  = $request->project_category_id;
        $data->sales_id             = \Auth::user()->id;
        $data->user_name            = $request->user_name;
        $data->password             = bcrypt($request->password);
        $data->project_type         = $request->project_type;
        if($request->project_type == 1){
            $data->license_number   = $request->license_number;
        }
        if($request->project_type == 2){
            $data->durataion            = $request->durataion;
            $data->expired_date         = $request->expired_date;
        }

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path('/storage/projects/'. $data->id);
            $file->move($destinationPath, $fileName);

            $data->file = $fileName;
        }
        $data->save();
        if($request->project_product_id != null)
        {
            foreach ($request->project_product_id as $key => $value) {
                $val = isset($value) ? 1 : 0;
                if($val == 1){
                # code...
                    $product = new ProjectProduct();
                    $product->crm_project_id  = $data->id;
                    $product->crm_product_id  = $request->project_product_id[$key];
                    if(isset($request->limit_user[$key])){
                        $product->limit_user      = $request->limit_user[$key];
                    }
                    $product->save();
                }
            }
        }
        
        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $data->id;
        $item->status               = 1;
        $item->item                 = 'price';
        $item->value                = replace_idr($request->price);
        $item->save();
        $item                       = new CrmProjectItems();
        $item->crm_project_id       = $data->id;
        $item->status               = 1;
        $item->item                 = 'type';
        $item->value                = $request->project_type;
        $item->save();

        if(isset($fileName))
        {
            $item                       = new CrmProjectItems();
            $item->crm_project_id       = $data->id;
            $item->status               = 1;
            $item->item                 = 'file';
            $item->value                = $fileName;
            $item->save();
        }

        if($data->project_category_id == 1)
        {
            //send to api
            $dataAPI   = CrmProjects::select('crm_projects.id as project_id','crm_projects.name as project_name','crm_client.name as client_name','crm_projects.user_name','crm_projects.password','project_product.crm_product_id','project_product.limit_user','crm_product.name as modul_name')
            ->join('crm_client', 'crm_client.id','=','crm_projects.crm_client_id')
            ->join('project_product', 'project_product.crm_project_id','=','crm_projects.id')
            ->join('crm_product','project_product.crm_product_id','=','crm_product.id')
            ->where('crm_projects.id', $data->id);

            $dataSend = clone $dataAPI;

            foreach ($dataSend->get() as $key => $value) {
                # code...
                $ch = curl_init();
                $data = "project_id=$value->project_id&project_name=$value->project_name&client_name=$value->client_name&crm_product_id=$value->crm_product_id&limit_user=$value->limit_user&modul_name=$value->modul_name";

                $url = 'http://api.em-hr.co.id/set-modul-hris';
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                
                $html = curl_exec($ch);

                if (curl_errno($ch)) 
                {
                    print curl_error($ch);
                }
                curl_close($ch);
                //dd($html);
            }

            $dataUser = $dataAPI->first();
            $data = "project_id=$dataUser->project_id&user_name=$dataUser->user_name&password=$dataUser->password";
            
            $ch = curl_init();
            $url = 'http://api.em-hr.co.id/set-user-hris';
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                
            $html = curl_exec($ch);

            if (curl_errno($ch)) 
            {
                print curl_error($ch);
            }
            curl_close($ch);

        }
        return redirect()->route('pipeline.index')->with('message-success', 'Card created');
    }

    /**
     * Calls
     * @return void
     */
    public function calls($id)
    {
        $project = CrmProjects::where('id', $id)->first();

        $data                       = new CrmProjectPipeline();
        $data->user_id              = \Auth::user()->id;
        $data->crm_project_id       = $id;
        $data->status_card          = 1;
        $data->pipeline_status      = $project->pipeline_status; 
        $data->value                = 'Calls';
        $data->save();

        return redirect()->route('pipeline.index');
    }

    /**
     * Reminder
     * @param 
     */
    public function reminder($id)
    {
        $project = CrmProjects::where('id', $id)->first();

        $data                       = new CrmProjectPipeline();
        $data->user_id              = \Auth::user()->id;
        $data->crm_project_id       = $id;
        $data->status_card          = 2;
        $data->pipeline_status      = $project->pipeline_status; 
        $data->value                = 'Reminder';
        $data->save();

        return redirect()->route('pipeline.index');
    }

     /**
     * Reminder
     * @param 
     */
    public function demo($id)
    {
        $project = CrmProjects::where('id', $id)->first();

        $data                       = new CrmProjectPipeline();
        $data->user_id              = \Auth::user()->id;
        $data->crm_project_id       = $id;
        $data->status_card          = 3;
        $data->pipeline_status      = $project->pipeline_status; 
        $data->value                = 'Demo';
        $data->save();

        return redirect()->route('pipeline.index');
    }

    /**
     * Reminder
     * @param 
     */
    public function terminate($id)
    {
        $project = CrmProjects::where('id', $id)->first();

        $data                       = new CrmProjectPipeline();
        $data->user_id              = \Auth::user()->id;
        $data->crm_project_id       = $id;
        $data->status_card          = 4;
        $data->pipeline_status      = $project->pipeline_status; 
        $data->value                = 'Terminate';
        $data->save();

        return redirect()->route('pipeline.index');
    }

     /**
     * Reminder
     * @param 
     */
    public function edit($id)
    {
        $project = CrmProjects::where('id', $id)->first();

        return view('project.edit')->with(['data' => $project]);
    }

    /**
     * Delete
     * @return void
     */
    public function delete($id)
    {
        $data   = CrmProjectPipeline::where('id', $id)->first();
        $data->delete();

        return redirect()->route('pipeline.index');
    }   
}