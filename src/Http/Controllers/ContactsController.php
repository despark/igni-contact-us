<?php

namespace Despark\Cms\ContactUs\Http\Controllers;

use Despark\Cms\Http\Controllers\AdminController;
use Despark\Cms\Http\Requests\AdminFormRequest;

class ContactsController extends AdminController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param AdminFormRequest $request
     *
     * @return Response
     */
    public function store(AdminFormRequest $request)
    {
        $input = $request->all();

        if ($input['type'] === 'address') {
            $input = $this->getGeocodeLocation($input);
        }

        if ($this->model instanceof Translatable) {
            $this->model->setActiveLocale($input['locale']);
        }
        $record = $this->model->create($input);

        if (method_exists($record, 'getManyToManyFields')) {
            foreach ($this->model->getManyToManyFields() as $metod => $array) {
                $record->$metod()->sync($request->get($array, []));
            }
        }

        $this->notify([
            'type' => 'success',
            'title' => 'Successful create!',
            'description' => $this->getResourceConfig()['name'] . ' is created successfully!',
        ]);

        return redirect(route($this->getResourceConfig()['id'] . '.edit', ['id' => $record->id]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminFormRequest $request
     * @param int $id
     *
     * @return Response
     */
    public function update(AdminFormRequest $request, $id)
    {
        $input = $request->all();

        if ($input['type'] === 'address') {
            $input = $this->getGeocodeLocation($input);
        }

        if ($this->model instanceof Translatable) {
            $this->model->setActiveLocale($input['locale']);
        }

        $record = $this->model->findOrFail($id);

        $record->update($input);

        if (method_exists($record, 'getManyToManyFields')) {
            foreach ($this->model->getManyToManyFields() as $metod => $array) {
                $record->$metod()->sync($request->get($array, []));
            }
        }

        $this->notify([
            'type' => 'success',
            'title' => 'Successful update!',
            'description' => $this->getResourceConfig()['name'] . ' is updated successfully.',
        ]);

        return redirect()->back();
    }

    /**
     * @param $input
     * @return mixed
     */
    public function getGeocodeLocation($input)
    {
        preg_match_all('/[^,;.]+/', $input['content'], $matches);
        $fullGeocodeAddress = '';
        foreach ($matches[0] as $match) {
            $fullGeocodeAddress .= str_replace(' ', '+', $match);
        }

        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $fullGeocodeAddress . '&sensor=false');
        $output = json_decode($geocode);
        $input['latitude'] = $output->results[0]->geometry->location->lat;
        $input['longitude'] = $output->results[0]->geometry->location->lng;

        return $input;
    }
}
