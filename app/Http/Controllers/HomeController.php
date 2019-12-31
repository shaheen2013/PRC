<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Accesstoken;
use App\Project;
use Asana;
use AsanaAuth;
use Session;


class HomeController extends Controller
{
    private $asanaAuth;
    protected $asana;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // See class comments and Asana API for extra info
        $this->asanaAuth = new AsanaAuth(env('ASANA_CLIENT_ID'), env('ASANA_CLIENT_SECRET'), env('ASANA_REDIRECT_URL'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($_GET['code'])){
            $code = $_GET['code'];
            $type = 'authorization_code';
            if(isset($_GET['refresh'])){
                $type = 'refresh_token';                
            }
            $data = [
                'grant_type'    => $type,
                'client_id'     => '1151360720602219',
                'client_secret' => '2806cc5908cf4fc63acaa27840062588',
                'redirect_uri'  => 'https://nova.local',
                'code'          => $_GET['code']
            ];
            if(isset($_GET['refresh'])){
                $data['refresh_token'] = $_GET['refresh'];      
            }
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://app.asana.com/-/oauth_token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $token = Accesstoken::where('client_id', '1151360720602219')->first();
                if(!$token){
                    $token = new Accesstoken();
                    $token->client_id = '1151360720602219';
                }
                $token->code = $_GET['code'];
                $token->token_type = json_decode($response)->token_type;
                $token->expires_in = json_decode($response)->expires_in;
                $token->access_token = json_decode($response)->access_token;
                $token->data = json_encode(json_decode($response)->data);
                $token->refresh_token = json_decode($response)->refresh_token;
                $token->save();

                $this->asana = new Asana([
                    'personalAccessToken' => json_decode($response)->access_token
                ]);

                // For Project Create -Added
                if(Session::has('createProjData')){
                    $dataRes = Session::get('createProjData');
                    $dataRes = json_decode($dataRes);
                    
                    
                    $data = [
                        'name' => $dataRes->name,
                        'workspace' => $dataRes->workspace,
                        'team' => $dataRes->team,
                        'osusr_mlv_community_id' => $dataRes->osusr_mlv_community_id,
                    ];
                    $rules = array(
                        'name' => 'required|string|max:255',
                        'workspace' => 'required|string',
                        'team' => 'required|string',
                        'osusr_mlv_community_id' => 'required|integer',
                    );
                    
                    $validator = Validator::make ($data, $rules);
                    
                    if ($validator->fails()){
                        return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
                    }
                    
                    try {
            
                        $project = json_decode($this->asana->createProject($data));
            
                        $newProject = new Project();
                        $newProject->osusr_mlv_community_id = $dataRes->osusr_mlv_community_id;
                        $newProject->project_id = $project->data->gid;
                        $newProject->save();
            
                        $this->asana->createSection($project->data->gid, ['name' => 'Sales']);
                        $this->asana->createSection($project->data->gid, ['name' => 'Maintenance']);
            
                        return redirect('/admin/resources/c-m-communities/'. $dataRes->osusr_mlv_community_id);
                    } catch (\Exception $e) {
                        return redirect('/admin/resources/c-m-communities');
                    }
                }
                return redirect('/admin/resources/c-m-communities');
            }
            return redirect('/admin/resources/c-m-communities');
        }
        return redirect('/admin');
    }

    public function syncContacts()
    {
        return view('syncContacts');
    }
}
