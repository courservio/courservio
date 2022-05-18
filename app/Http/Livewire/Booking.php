<?php

namespace App\Http\Livewire;

use App\Models\ContactPerson;
use App\Models\Course;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Booking extends Component
{
    public bool $samePerson = true;
    public bool $bookingSuccessful = false;
    public string $course;
    public string $price;
    public string $payment = '';
    public array $participants = [[]];
    public array $contactPerson = [];

    protected function rules(): array
    {
        return [
            'contactPerson.company' => 'sometimes',
            'contactPerson.firstname' => 'required',
            'contactPerson.lastname' => 'required',
            'contactPerson.street' => 'required',
            'contactPerson.zipcode' => 'required',
            'contactPerson.location' => 'required',
            'contactPerson.email' => 'required',
            'contactPerson.phone' => 'required',
            'participants.*.firstname' => 'required',
            'participants.*.lastname' => 'required',
            'participants.*.date_of_birth' => 'required',
        ];
    }

    public function mount() // needed to make $this->course available automatically
    {

    }

    public function addParticipant()
    {
        $this->participants = array_filter($this->participants); // remove empty values
        $this->participants[] = [];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedContactPersonCompany()
    {
        if ($this->contactPerson['company'] === '') {
            unset($this->contactPerson['company']);
        }
    }

    public function updatedContactPerson($value, $field)
    {
        // update participant if is same person and contact person is updated
        if ($this->samePerson) {
            if ($field == 'firstname') {
                $this->participants[0]['firstname'] = $value;
            }

            if ($field == 'lastname') {
                $this->participants[0]['lastname'] = $value;
            }

            if ($field == 'email') {
                $this->participants[0]['email'] = $value;
            }

            if ($field == 'phone') {
                $this->participants[0]['phone'] = $value;
            }
        }
    }

    public function removeParticipant($participant)
    {
        unset($this->participants[$participant]);
        $this->participants = array_values($this->participants);
    }

    public function save($course_id, $price_id)
    {
        $this->participants = array_filter($this->participants); // remove empty values

        $this->validate();

        if ( // check if the contact person is the participant
            $this->samePerson &&
            count($this->participants) === 1 &&
            $this->participants[0]['lastname'] == $this->contactPerson['lastname'] &&
            $this->participants[0]['firstname'] == $this->contactPerson['firstname']
        ) {
            $participant = Participant::create([
                'course_id' => $course_id,
                'contact_id' => null,
                'lastname' => $this->contactPerson['lastname'],
                'firstname' => $this->contactPerson['firstname'],
                'date_of_birth' => Carbon::parse($this->participants[0]['date_of_birth'])->isoFormat('YYYY-MM-DD'),
                'company' => $this->contactPerson['company'] ?? '',
                'street' => $this->contactPerson['street'],
                'zipcode' => $this->contactPerson['zipcode'],
                'location' => $this->contactPerson['location'],
                'phone' => $this->contactPerson['phone'],
                'email' => $this->contactPerson['email'],
                'price' => '0',
                'price_id' => $price_id,
            ]);

        } else { // contact person != participant(s)
            // create contact person
            $contactPerson = ContactPerson::create([
                'lastname' => $this->contactPerson['lastname'],
                'firstname' => $this->contactPerson['firstname'],
                'company' => $this->contactPerson['company'] ?? '',
                'street' => $this->contactPerson['street'],
                'zipcode' => $this->contactPerson['zipcode'],
                'location' => $this->contactPerson['location'],
                'phone' => $this->contactPerson['phone'],
                'email' => $this->contactPerson['email'],
            ]);

            $participants = [];

            // some preparation for bulk insert
            foreach ($this->participants as $participant) {
                $participant['course_id'] = $course_id;
                $participant['contact_id'] = $contactPerson->id;
                $participant['date_of_birth'] = Carbon::parse($participant['date_of_birth'])->isoFormat('YYYY-MM-DD');
                $participant['email'] = $participant['email'] ?? '';
                $participant['phone'] = $participant['phone'] ?? '';
                $participant['created_at'] = Carbon::now();
                $participant['updated_at'] = Carbon::now();
                $participants[] = $participant;
            }

            $participant = Participant::insert(
                $participants
            );
        }

        if ($participant) { // success
            $this->bookingSuccessful = true;
        }
    }

    public function render()
    {
        $course_data = Course::where('id', '=', Hashids::decode($this->course))
            ->where('cancelled', '=', NULL)
            ->where('public_bookable', '=', 1)
            ->whereRelation('prices', 'id', '=', Hashids::decode($this->price))
            ->with('type')
            ->with(['prices' => fn($query) => $query->where('id', '=', Hashids::decode($this->price))])
                ->whereHas('prices', function (Builder $query) {
                    $query->where('id', '=', Hashids::decode($this->price));
                })
            ->withCount(['participants' => fn($query) => $query->where('cancelled', 0)])
            ->get();

        return view('livewire.booking', [
            'course_data' => $course_data[0],
        ])
            ->layout('layouts.booking', ['metaTitle' => _i('Book course')]);
    }
}