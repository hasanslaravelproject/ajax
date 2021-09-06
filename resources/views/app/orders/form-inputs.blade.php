@php $editing = isset($order) @endphp
@php $date1= date("Y-d-m") 
@endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="delivery_date"
            label="Delivery Date"
            value="{{ old('delivery_date', $date1) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
    
    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="order_quantity"
            label="Order Quantity"
            value="{{ old('order_quantity', ($editing ? $order->order_quantity : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="customer_id" label="Customer" required>
            @php $selected = old('customer_id', ($editing ? $order->customer_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Customer</option>
            @foreach($customers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="menu_id" label="Menu" required>
            @php $selected = old('menu_id', ($editing ? $order->menu_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Menu</option>
            @foreach($menus as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
