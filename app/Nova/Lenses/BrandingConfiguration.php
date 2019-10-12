<?php

namespace App\Nova\Lenses;

use Carbon\Carbon;
use Inspheric\Fields\Url;
use Inspheric\Fields\Email;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Fields\Image;
use Davidpiesse\NovaToggle\Toggle;
use Dniccum\PhoneNumber\PhoneNumber;
use Laravel\Nova\Http\Requests\LensRequest;
use Saumini\EllipsisTextarea\EllipsisTextarea;
use App\Nova\Actions\ExportBrandingConfiguration;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class BrandingConfiguration extends Lens
{
    public $name = 'Branding Configuration';

    protected static function columns()
    {
        return [
            'osusr_mlv_community.COMMUNITYID',
            'osusr_mlv_community.FRIENDLYNAME',
            'osusr_mlv_community.COUNTY',
//            'osusr_mlv_community.STATE',
            'cm_community_branding_configurations.redirect_url',
            'cm_community_branding_configurations.redirect_email',
            'cm_community_branding_configurations.redirect_phone',
            'cm_community_branding_configurations.landing_page_content',
            'osusr_tvl_crm.SALESSTATUSID',
            'cm_rental_vacant_sales_statuses.rental_status',
            'cm_rental_vacant_sales_statuses.vacant_status',
//            'cm_community_logos.logo'
        ];
    }

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        $resourceTable = 'osusr_mlv_community';
        $orderBy = $request->get('orderBy');
        if ($orderBy == 'redirect_url') {
            $query->getQuery()->orders = null;
            $query->orderBy('redirect_url', $request->get('orderByDirection'));
        }

        return
            $query->select(self::columns())
//                ->leftJoin('cm_community_logos', "{$resourceTable}.COMMUNITYID", '=', 'cm_community_logos.community_id')
                ->leftJoin('cm_community_branding_configurations', "{$resourceTable}.COMMUNITYID", '=', 'cm_community_branding_configurations.community_id')
                ->leftJoin('osusr_tvl_crm', "{$resourceTable}.COMMUNITYID", '=', 'osusr_tvl_crm.COMMUNITYID')
                ->leftJoin('cm_rental_vacant_sales_statuses', "{$resourceTable}.COMMUNITYID", '=', 'cm_rental_vacant_sales_statuses.community_id')
//                ->where('osusr_tvl_crm.SALESSTATUSID', '=', '5')
//                ->orWhere('osusr_tvl_crm.SALESSTATUSID', '=', '14')
//                ->orWhere('cm_rental_vacant_sales_statuses.rental_status', '=', '5')
//                ->orWhere('cm_rental_vacant_sales_statuses.rental_status', '=', '14')
//                ->orWhere('cm_rental_vacant_sales_statuses.vacant_status', '=', '5')
//                ->orWhere('cm_rental_vacant_sales_statuses.vacant_status', '=', '14')
;
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('Community ID', 'COMMUNITYID')->sortable(),
            EllipsisTextarea::make('Community', 'FRIENDLYNAME')->sortable()->displayLength(20),
            Text::make('County', 'COUNTY')->sortable(),
//            Text::make('State', 'STATE')->sortable(),
            Image::make('Logo')->disk('s3')->sortable(),
            Toggle::make('Redirect Url', 'redirect_url'),
            Toggle::make('Redirect Email', 'redirect_email'),
            Toggle::make('Redirect Phone Number', 'redirect_phone'),
            Toggle::make('Landing Page Content', 'landing_page_content'),
        ];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new DownloadExcel,
            (new ExportBrandingConfiguration())
                ->withChunkCount(200)
                ->withFilename('Community_Branding_Config-'.Carbon::now()->format('YmdHs').'.xlsx')
                ->withHeadings('Id', 'Community', 'County', 'State', 'Logo', 'Redirect URL', 'Redirect Email', 'Redirect Phone Number', 'Landing Page Content'),
        ];
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'branding-configuration';
    }
}
