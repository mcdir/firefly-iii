<?php
/**
 * PiggyBankStoreRequest.php
 * Copyright (c) 2019 james@firefly-iii.org
 *
 * This file is part of Firefly III (https://github.com/firefly-iii).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace FireflyIII\Api\V1\Requests;

use FireflyIII\Support\Request\ChecksLogin;
use FireflyIII\Support\Request\ConvertsDataTypes;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PiggyBankStoreRequest
 *
 * @codeCoverageIgnore
 */
class PiggyBankStoreRequest extends FormRequest
{
    use ConvertsDataTypes, ChecksLogin;

    /**
     * Get all data from the request.
     *
     * @return array
     */
    public function getAll(): array
    {
        return [
            'name'            => $this->string('name'),
            'account_id'      => $this->integer('account_id'),
            'targetamount'    => $this->string('target_amount'),
            'current_amount'  => $this->string('current_amount'),
            'startdate'       => $this->date('start_date'),
            'targetdate'      => $this->date('target_date'),
            'notes'           => $this->nlString('notes'),
            'object_group_id' => $this->integer('object_group_id'),
            'object_group'    => $this->string('object_group_name'),
        ];
    }

    /**
     * The rules that the incoming request must be matched against.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'            => 'required|between:1,255|uniquePiggyBankForUser',
            'current_amount'  => ['numeric', 'gte:0', 'lte:target_amount'],
            'account_id'      => 'required|numeric|belongsToUser:accounts,id',
            'object_group_id' => 'numeric|belongsToUser:object_groups,id',
            'target_amount'   => ['numeric', 'gte:0', 'lte:target_amount', 'required'],
            'start_date'      => 'date|nullable',
            'target_date'     => 'date|nullable|after:start_date',
            'notes'           => 'max:65000',
        ];
    }

}
