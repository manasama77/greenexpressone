<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string|null $photo
 * @property string|null $email
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUsername($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Banner
 *
 * @property int $id
 * @property string $picture
 * @property string $url
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUrl($value)
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Booking
 *
 * @property int $id
 * @property string $booking_number
 * @property int $schedule_id
 * @property int $from_master_area_id
 * @property string $from_master_area_name
 * @property int|null $from_master_sub_area_id
 * @property string|null $from_master_sub_area_name
 * @property int $to_master_area_id
 * @property string $to_master_area_name
 * @property int|null $to_master_sub_area_id
 * @property string|null $to_master_sub_area_name
 * @property string $vehicle_name
 * @property string $vehicle_number
 * @property string $datetime_departure
 * @property string $schedule_type
 * @property int $user_id
 * @property int $qty_adult
 * @property int $qty_baby
 * @property int $special_request
 * @property string|null $flight_number
 * @property string|null $notes
 * @property int $luggage_qty
 * @property string $luggage_price
 * @property string $extra_price
 * @property int|null $voucher_id
 * @property string $promo_price
 * @property string $base_price
 * @property string $total_price
 * @property string $booking_status
 * @property string $payment_status
 * @property string|null $payment_method
 * @property string|null $payment_token
 * @property string $total_payment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookingStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDatetimeDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereExtraPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFlightNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFromMasterAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFromMasterAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFromMasterSubAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereFromMasterSubAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereLuggagePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereLuggageQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePromoPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereQtyAdult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereQtyBaby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereScheduleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSpecialRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereToMasterAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereToMasterAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereToMasterSubAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereToMasterSubAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTotalPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereVehicleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereVehicleNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereVoucherId($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookingSequence
 *
 * @property int $id
 * @property string $date_sequence
 * @property int $current_sequence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence whereCurrentSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence whereDateSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingSequence whereUpdatedAt($value)
 */
	class BookingSequence extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Charter
 *
 * @property int $id
 * @property string $from_master_area_id
 * @property string|null $from_master_sub_area_id
 * @property string $to_master_area_id
 * @property string|null $to_master_sub_area_id
 * @property string $vehicle_name
 * @property string $vehicle_number
 * @property int $is_available
 * @property string|null $photo
 * @property string $price
 * @property string|null $driver_contact
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Charter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Charter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Charter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereDriverContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereFromMasterAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereFromMasterSubAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereToMasterAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereToMasterSubAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereVehicleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Charter whereVehicleNumber($value)
 */
	class Charter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterArea
 *
 * @property int $id
 * @property string $name
 * @property string $area_type
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MasterSubArea[] $master_sub_area
 * @property-read int|null $master_sub_area_count
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea query()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea whereAreaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterArea whereUpdatedAt($value)
 */
	class MasterArea extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterSpecialArea
 *
 * @property int $id
 * @property int $master_sub_area_id
 * @property string $first_person_price
 * @property string $extra_person_price
 * @property int $is_active
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea query()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereExtraPersonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereFirstPersonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereMasterSubAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSpecialArea whereUpdatedAt($value)
 */
	class MasterSpecialArea extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterSubArea
 *
 * @property int $id
 * @property int $master_area_id
 * @property string $name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\MasterArea $master_area
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea query()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea whereMasterAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterSubArea whereUpdatedAt($value)
 */
	class MasterSubArea extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $page_title
 * @property string $page_content
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePageContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePageTitle($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ScheduleShuttle
 *
 * @property int $id
 * @property string $from_master_area_id
 * @property string|null $from_master_sub_area_id
 * @property string $to_master_area_id
 * @property string|null $to_master_sub_area_id
 * @property string $vehicle_name
 * @property string $vehicle_number
 * @property string $time_departure
 * @property int $is_active
 * @property string|null $photo
 * @property string $price
 * @property string|null $driver_contact
 * @property string|null $notes
 * @property int $total_seat
 * @property string $luggage_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle query()
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereDriverContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereFromMasterAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereFromMasterSubAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereLuggagePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereTimeDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereToMasterAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereToMasterSubAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereTotalSeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereVehicleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleShuttle whereVehicleNumber($value)
 */
	class ScheduleShuttle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $password
 * @property string|null $photo
 * @property string|null $email
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Voucher
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $date_start
 * @property string $date_expired
 * @property string $discount_type
 * @property string $discount_value
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereDateExpired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Voucher whereUpdatedAt($value)
 */
	class Voucher extends \Eloquent {}
}

