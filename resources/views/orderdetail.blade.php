<x-front-layout>
    <!-- Main Content -->
    <section class="bg-darkGrey relative py-[70px]" data-aos="fade-up">
        <div class="container">
            <header class="mb-[30px]">
                <h2 class="font-bold text-dark text-[26px] mb-1">
                    Track your order here
                </h2>
                <p class="text-base text-secondary">We will help you get ready today</p>
            </header>

            <div class="flex items-center gap-5 lg:justify-between">
                <!-- Form Card -->

                <div class="grid grid-cols-2 items-center gap-y-6 gap-x-4 lg:gap-x-[30px]">
                    <!-- Full Name -->
                    <div class="flex flex-col col-span-2 gap-3">
                        <label for="" class="text-base font-semibold text-dark">
                            Full Name
                        </label>
                        <input readonly
                            class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                            value="{{ $detail->name }}">
                    </div>

                    <!-- START: INPUT DATE -->
                    <div class="col-span-2 grid grid-cols-2 gap-y-6 gap-x-4 lg:gap-x-[30px] relative"
                        @keydown.escape="closeDatepicker()" @click.outside="closeDatepicker()">
                        <!-- Date From -->
                        <div class="flex flex-col col-span-1 gap-3">
                            <label for="" class="text-base font-semibold text-dark">
                                From
                            </label>
                            <input readonly type="text"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                                placeholder="Select Date" @click="endToShow = 'from'; init(); showDatepicker = true"
                                x-model="outputDateFromValue"
                                value="{{ date('d-m-Y', strtotime($detail->start_date)) }}">
                        </div>
                        <!-- Date Until -->
                        <div class="flex flex-col col-span-1 gap-3">
                            <label for="" class="text-base font-semibold text-dark">
                                Until
                            </label>
                            <input readonly type="text"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                                placeholder="Select Date" @click="endToShow = 'to'; init(); showDatepicker = true"
                                x-model="outputDateToValue" value="{{ date('d-m-Y', strtotime($detail->end_date)) }}">
                        </div>
                    </div>
                    <!-- END: INPUT DATE -->

                    <!-- group payment status and total price -->
                    <div class="col-span-2 grid grid-cols-2 gap-y-6 gap-x-4 lg:gap-x-[30px] relative">
                        <!-- payment stauts -->
                        <div class="flex flex-col col-span-1 gap-3">
                            <label for="" class="text-base font-semibold text-dark">
                                Payment Status
                            </label>
                            <input readonly type="text"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                                value="{{ $detail->payment_status }}">
                        </div>
                        <!-- order status -->
                        <div class="flex flex-col col-span-1 gap-3">
                            <label for="" class="text-base font-semibold text-dark">
                                Total Price
                            </label>
                            <input readonly type="text"
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                                value="Rp {{ number_format($detail->total_price) }}">
                        </div>
                    </div>


                    {{-- if payment is pending show url payment --}}
                    @if ($detail->payment_status == 'pending')
                        <div class="col-span-2">
                            <!-- Button Primary -->
                            <div class="p-1 rounded-full bg-primary group">
                                <a target="_blank" rel="noopener noreferrer" href="{{ $detail->payment_url }}"
                                    class="btn-primary">
                                    <p>
                                        Continue Payment
                                    </p>
                                    <img src="/svgs/ic-arrow-right.svg" alt="">
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- order status -->
                    <div class="flex flex-col col-span-2 gap-3">
                        <label for="" class="text-base font-semibold text-dark">
                            Order Status
                        </label>
                        <input readonly
                            class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                            value="{{ $detail->status }}">
                    </div>

                    @if ($detail->with_delivery == 'Yes with delivery')
                        <!-- Delivery Address -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="" class="text-base font-semibold text-dark">
                                Delivery Address
                            </label>
                            <input readonly type="text" name="address" id="address" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px]"
                                placeholder="Where should we deliver your car?" value="{{ $detail->address }}">
                        </div>

                        <!-- City -->
                        <div class="flex flex-col col-span-2 gap-3">
                            <label for="" class="text-base font-semibold text-dark">
                                City
                            </label>
                            <input readonly type="text" name="city" id="city" required
                                class="text-base font-medium focus:border-primary focus:outline-none placeholder:text-secondary placeholder:font-normal px-[26px] py-4 border border-grey rounded-[50px] focus:before:appearance-none focus:before:!content-none"
                                placeholder="City Name" value="{{ $detail->city }}">
                        </div>
                    @endif

                </div>

                <img src="{{ Storage::url($detail->item->thumbnail_photos) }}"
                    class="max-w-[50%] hidden lg:block -mr-[200px]" alt="">
            </div>
        </div>
    </section>
</x-front-layout>
