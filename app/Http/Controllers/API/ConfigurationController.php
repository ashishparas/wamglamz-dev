<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\User;
use App\Configuration as MyModel;

class ConfigurationController extends ApiController {

    public function getPrivacyPolicyColumn(Request $request, $column) {

        try {

            $key  = $column.'_customer';
         
            return parent::success(MyModel::first()->$key, 200, 'data');
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function getConfigurationColumn(Request $request, $column) {

        $user = User::findOrFail(\Auth::id());
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'GET', $rules, array_keys($rules), false);
        if ($validateAttributes):
            return $validateAttributes;
        endif;
        try {

            if (!in_array($column, ['terms_and_conditions', 'private_policy']))
                return parent::error('Please use valid column');
//dd($column);
            $key = '';
//            if ($column == 'terms_and_conditions'):
            if ($user->hasRole('Customer') === true)
                $key = '_customer';
            if ($user->hasRole('Service-provider') === true)
                $key = '_service_provider';
            $var = $column . $key;
            return parent::success(MyModel::first()->$var, 200, 'data');
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

}
