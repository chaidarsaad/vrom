<x-front-layout>
    <!-- Extra Benefits -->
    <section class="container relative pt-[100px]">
        <div class="flex items-center flex-col md:flex-row flex-wrap justify-center gap-8 lg:gap-[120px]">
            <img src="/images/illustration-01.webp" class="w-full lg:max-w-[536px]" alt="" data-aos="fade-up">
            <div class="max-w-[268px] w-full">
                <div class="flex flex-col gap-[30px]">
                    <header>
                        <h2 class="font-bold text-dark text-[26px] mb-1" data-aos="fade-up">
                            Extra Benefits
                        </h2>
                        <p class="text-base text-secondary" data-aos="fade-up">You drive safety and famous</p>
                    </header>
                    <!-- Benefits Item -->
                    @php $incrementBenefit = 0 @endphp

                    <div class="flex items-center gap-4" data-aos="fade-up"
                        data-aos-delay="{{ $incrementBenefit += 100 }}">
                        <div class="bg-dark rounded-[26px] p-[19px]">
                            <img src="/svgs/ic-car.svg" alt="">
                        </div>
                        <div>
                            <h5 class="text-lg text-dark font-bold mb-[2px]">
                                Delivery
                            </h5>
                            <p class="text-sm font-normal text-secondary">Just sit tight and wait</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4" data-aos="fade-up"
                        data-aos-delay="{{ $incrementBenefit += 100 }}">
                        <div class="bg-dark rounded-[26px] p-[19px]">
                            <img src="/svgs/ic-card.svg" alt="">
                        </div>
                        <div>
                            <h5 class="text-lg text-dark font-bold mb-[2px]">
                                Pricing
                            </h5>
                            <p class="text-sm font-normal text-secondary">12x Pay Installment</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4" data-aos="fade-up"
                        data-aos-delay="{{ $incrementBenefit += 100 }}">
                        <div class="bg-dark rounded-[26px] p-[19px]">
                            <img src="/svgs/ic-securityuser.svg" alt="">
                        </div>
                        <div>
                            <h5 class="text-lg text-dark font-bold mb-[2px]">
                                Secure
                            </h5>
                            <p class="text-sm font-normal text-secondary">Use your plate number</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4" data-aos="fade-up"
                        data-aos-delay="{{ $incrementBenefit += 100 }}">
                        <div class="bg-dark rounded-[26px] p-[19px]">
                            <img src="/svgs/ic-convert3dcube.svg" alt="">
                        </div>
                        <div>
                            <h5 class="text-lg text-dark font-bold mb-[2px]">
                                Fast Trade
                            </h5>
                            <p class="text-sm font-normal text-secondary">Change car faster</p>
                        </div>
                    </div>
                </div>
                <!-- CTA Button -->
                <div class="mt-[50px]">
                    <!-- Button Primary -->
                    <div class="p-1 rounded-full bg-primary group" data-aos="fade-up"
                        data-aos-delay="{{ $incrementBenefit += 100 }}">
                        <a href="{{ route('front.catalog') }}" class="btn-primary">
                            <p>
                                Explore Cars
                            </p>
                            <img src="/svgs/ic-arrow-right.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="container relative py-[100px]">
        <header class="text-center mb-[50px]">
            <h2 class="font-bold text-dark text-[26px] mb-1" data-aos="fade-up">
                Frequently Asked Questions
            </h2>
            <p class="text-base text-secondary" data-aos="fade-up">Learn more about Vrom and get a success</p>
        </header>

        <!-- Questions -->
        <div class="grid md:grid-cols-2 gap-x-[50px] gap-y-6 max-w-[910px] w-full mx-auto">
            @php
                $ques = 0;
                $ans = 0;
                $incrementFaq = 0;
            @endphp
            @foreach ($questions as $question)
                <a href="#!" class="px-6 py-4 border rounded-[24px] border-grey h-min accordion max-w-[430px]"
                    id="faq{{ $ques++ }}" data-aos="fade-up" data-aos-delay="{{ $incrementFaq += 100 }}">
                    <div class="flex items-center justify-between gap-1">
                        <p class="text-base font-semibold text-dark">
                            {{ $question->question }}
                        </p>
                        <img src="/svgs/ic-chevron-down-rounded.svg" class="transition-all" alt="">
                    </div>
                    <div class="hidden pt-4 max-w-[335px]" id="faq{{ $ans++ }}-content">
                        <p class="text-base text-justify text-dark leading-[26px]">
                            {{ $question->answer }}
                        </p>
                    </div>
                </a>
            @endforeach
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
