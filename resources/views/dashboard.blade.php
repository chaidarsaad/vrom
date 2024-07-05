<x-front-layout>

    <!-- Popular Cars -->
    <section class="bg-darkGrey">
        <div class="container relative py-[100px]">
            <header class="mb-[30px]" data-aos="fade-up">
                <h2 class="font-bold text-dark text-[26px] mb-1">
                    My Order
                </h2>
            </header>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-[29px]">
                @php $incrementCars = 0 @endphp
                @forelse ($rent as $rentcar)
                    <!-- Card -->
                    <div class="card-popular" data-aos="fade-up" data-aos-delay="{{ $incrementCars += 100 }}">
                        <div>
                            <h5 class="text-lg text-dark font-bold mb-[2px]">
                                {{ $rentcar->item->brand->name }} {{ $rentcar->item->name }}
                            </h5>
                            <p class="text-sm font-normal text-secondary">
                                {{ $rentcar->item->type ? $rentcar->item->type->name : '-' }}
                            </p>
                            <a href="{{ route('front.mydashboard.detail', $rentcar->booking_code) }}"
                                class="absolute inset-0"></a>
                        </div>
                        <img src="{{ Storage::url($rentcar->item->thumbnail_photos) }}"
                            class="rounded-[18px] w-full h-full" alt="">
                        <div class="flex rentcars-center justify-between gap-1">
                            <!-- Price -->
                            <p class="text-sm font-normal text-secondary">
                                <span class="text-base font-bold text-primary">Status
                                    {{ $rentcar->status }}</span>
                                {{-- {{ number_format($rentcar->price) }}</span>/day --}}
                            </p>
                        </div>
                    </div>
                @empty
                    <header class="mb-[30px]" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="text-base text-secondary text-[26px] mb-1">
                            Null Order
                        </h2>
                    </header>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Instant Booking -->
    @if (!$hero == null)
        <section class="relative bg-[#060523]">
            <div class="container py-20">
                <div class="flex flex-col">
                    <header class="mb-[50px] max-w-[360px] w-full">
                        <h2 class="font-bold text-white text-[26px] mb-4" data-aos="fade-up">
                            Drive Yours Today. <br>
                            Drive Faster.
                        </h2>
                        <p class="text-base text-subtlePars" data-aos="fade-up">Get an instant booking to catch up
                            whatever your
                            really want to achieve today, yes.</p>
                    </header>
                    <!-- Button Primary -->
                    <div class="p-1 rounded-full bg-primary group w-max" data-aos="fade-up">
                        <a href="{{ route('front.detail', $hero->slug) }}" class="btn-primary">
                            <p>
                                Book Now
                            </p>
                            <img src="/svgs/ic-arrow-right.svg" alt="">
                        </a>
                    </div>

                </div>
                <div class="absolute bottom-[-30px] right-0 lg:w-[764px] max-h-[332px] hidden lg:block"
                    data-aos="fade-up">
                    <img src="{{ Storage::url($hero->thumbnail_photos) }}" alt="">
                </div>
            </div>
        </section>
    @endif

    <footer class="py-10 md:pt-[100px] md:pb-[70px] container">
        <p class="text-base text-center text-secondary">
            All Rights Reserved.
        </p>
    </footer>
</x-front-layout>
