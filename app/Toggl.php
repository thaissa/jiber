<?php

/**
 * Copyright 2016 Thaissa Mendes
 *
 * This file is part of Jiber.
 *
 * Jiber is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jiber is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jiber. If not, see <http://www.gnu.org/licenses/>.
 */

namespace App;

/**
 * This model is extended by all Toggl's models
 */

class Toggl extends MainModel
{
    /**
     * Get record based on Toggl ID and User ID
     */
    public static function getByTogglID($toggl_id, $user_id)
    {
        return self::where(array(
            'toggl_id' => $toggl_id,
            'user_id'  => $user_id,
        ))->get()->first();
    }
}
