@php $editing = isset($menu) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $menu->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
    
  <!--   <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
            name="menu_starts"
            label="Menu Starts"
            value="{{ old('menu_starts', ($editing ? optional($menu->menu_starts)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group> -->
    
  <!--   <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="validity"
            label="Validity"
            value="{{ old('validity', ($editing ? $menu->validity : '')) }}"
            max="255"
        ></x-inputs.number>
    </x-inputs.group> -->

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $menu->image ? \Storage::url($menu->image) : '' }}')"
        >
            <x-inputs.partials.label
                name="image"
                label="Image"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="image"
                    id="image"
                    @change="fileChosen"
                />
            </div>

            @error('image') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="menu_types_id" label="Menu Types" required>
            @php $selected = old('menu_types_id', ($editing ? $menu->menu_types_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Menu Types</option>
            @foreach($allMenuTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="meal_type_id" label="Meal Type" required>
            @php $selected = old('meal_type_id', ($editing ? $menu->meal_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Meal Type</option>
            @foreach($mealTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

  <!--   <x-inputs.group class="col-sm-12">
        <x-inputs.select name="food_id" label="Food" required>
            @php $selected = old('food_id', ($editing ? $menu->food_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Food</option>
            @foreach($foods as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group> -->

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="company_id" label="Company" required>
            @php $selected = old('company_id', ($editing ? $menu->company_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Company</option>
            @foreach($companies as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
