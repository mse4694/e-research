<script setup>
import {reactive, ref, onMounted, onUnmounted, computed} from 'vue'
import { Head, useForm, router } from '@inertiajs/vue3';
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionRoot,
    TransitionChild,
    Disclosure, DisclosureButton, DisclosurePanel
} from '@headlessui/vue'
import * as dayjs from 'dayjs'
import * as localizedFormat from 'dayjs/plugin/localizedFormat'
import * as relativeTime from 'dayjs/plugin/relativeTime'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { FunnelIcon, XMarkIcon, ChevronDoubleUpIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline'
import Field from '../Components/Field.vue'
import BaseInput from '../Components/BaseInput.vue'
import BaseRadioGroup from '../Components/Radio/BaseRadioGroup.vue'
import BaseLabel from '../Components/BaseLabel.vue'
import BaseListbox from '../Components/BaseListbox.vue';
import Alert from '../Components/Alert.vue';
import Avatar from '../Components/Avatar.vue';
import Paginate from '../Components/Pagination.vue'
import Button from '../Components/Button.vue'
import backgroundImgUrl from '@/Asset/images/background-book.png'
import Profile from '../Components/Profile.vue'

dayjs.extend(localizedFormat)
dayjs.extend(relativeTime)

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    researchs: {
        type: Object,
        default: []
    },
    filters: Object ,
    start_year: String,
    end_year: String,
});

const form = useForm({
  item_per_page: props.filters.item_per_page ? props.filters.item_per_page : 5,
  title: props.filters.title ? props.filters.title : null,
  keyword: props.filters.keyword ? props.filters.keyword : null,
  author: props.filters.author ? props.filters.author : null,
  journal_name: props.filters.journal_name ? props.filters.journal_name : null,
  doi: props.filters.doi ? props.filters.doi : null,
  publication_date_range: props.filters.publication_date_range ? props.filters.publication_date_range : 0,
  custom_publication_date_range: props.filters.custom_publication_date_range ? props.filters.custom_publication_date_range : null,
})

const publication_date = [
    { value: 1, label: '1 year' },
    { value: 2, label: '2 years' },
    { value: 'custom', label: 'Custom' },
]

//const backgroundImgUrl = new URL('@/assets/images/background2.jpg', import.meta.url)
const isOpen = ref(false)
const toTopButton = ref(false)
const scrollPosition = ref(null)
let checkoutButtonRef =ref(null)
const showAlert = ref(false)
let userInfo = reactive({})
const disableButtonStatus = ref(false)

onMounted(() => {
  window.addEventListener("scroll", updateScroll);
})

onUnmounted(() => {
  window.removeEventListener("scroll", updateScroll);
})

function setIsOpen(value) {
    isOpen.value = value
}

function clearAllFilter() {
  form.title = null
  form.keyword = null
  form.author = null
  form.journal_name = null
  form.doi = null
  form.publication_date_range = 0
  form.custom_publication_date_range = null
  disableButtonStatus.value = false
    //form.reset()
    //setIsOpen(false)
}

function findUser(arr, val) {
    const myUser =  arr.find((arrVal) => val === arrVal.id)
    let info =  `{"name":"${myUser.firstName} ${myUser.lastName}", "ein":"${myUser.ein}", "ssn":"${myUser.ssn}", "doi":"${myUser.address.coordinates.lat}/${myUser.username}"}`
    userInfo = JSON.parse(info)
}

const updateScroll = (event) => {
  scrollPosition.value = window.scrollY
    toTopButton.value = scrollPosition.value > 200;
}

const goToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

const createData = () => {
    //let error_display = ''

    router.post(route('create-data'), {}, {
        preserveState: true,
        onSuccess: () => {
            console.log('success')
            showAlert.value = true
        },
        // onError: (errors) => {
        //     for ( let p in errors ) {
        //         error_display = error_display + `- ${errors[p]}<br/>`
        //     }
        //     showAlert.value = true
        // },
        // onFinish: () => {
        //     divisionForm.processing = false
        // }
    });
}

const importData = () => {
    //let error_display = ''

    router.post(route('import-research'), {}, {
        preserveState: true,
        onSuccess: () => {
            console.log('success')
            showAlert.value = true
        },
    });
}

const checkCustomRange = computed( () => {
  //return true
  //console.log(form.custom_publication_date_range.length)
  if( form.custom_publication_date_range?.length ) {
    disableButtonStatus.value = false
  }

})

const searchButton = () => {
  setIsOpen(false)
  form.get(route('index'),  {
    preserveState: true,
    replace: true,
    onFinish: () => setIsOpen(false),
  })
}

const showCustomRange = computed(() => {
  //console.log(typeof(form.publication_date))
  if( form.publication_date_range == 'custom' ) {
    disableButtonStatus.value = true
    return true
  }
  disableButtonStatus.value = false
  form.custom_publication_date_range = null
  //form.reset('custom_publication_date_range')
  return false
})

</script>

<template>
    <TransitionRoot appear as="template" :show="isOpen">
        <Dialog
            :initial-focus="checkoutButtonRef"
            class="fixed inset-0 overflow-hidden z-10"
            :open="isOpen" @close="setIsOpen">
            <TransitionChild
                enter="transition-opacity ease-in-out duration-300"
                enter-from="-translate-x-full"
                enter-to="translate-x-0"
                leave="transition-opacity ease-in-out duration-300"
                leave-from="translate-x-0"
                leave-to="-translate-x-full"
                as="template">
                <DialogOverlay class="absolute inset-0 bg-black bg-opacity-40"></DialogOverlay>
            </TransitionChild>

            <TransitionChild
                enter="transition-opacity ease-linear duration-200"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
                as="template">
                <div class="flex flex-col bg-white fixed inset-y-0 left-0 w-full max-w-xs">
                    <div class="flex items-center justify-between p-4 shadow bg-green-800 text-white">
                        <DialogTitle class="text-lg font-semibold">Additional filters</DialogTitle>
                        <button @click="setIsOpen(false)" class="p-1 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            <XMarkIcon class="w-6 h-6"></XMarkIcon>
                        </button>
                    </div>

                    <div class="flex flex-col flex-1">
                        <div class="flex-1 relative">
                            <div class="absolute inset-0 overflow-y-scroll">
                                <div class="flex flex-col px-4 py-2 space-y-4">
                                    <BaseListbox
                                      label="DISPLAY (DEFAULT 5)"
                                      placeholder="Please Select"
                                      v-model="form.item_per_page"
                                      :options="[{value: 5, label: '5'}, {value: 10, label: '10'}, {value: 20, label: '20'}, {value: 50, label: '50'}]"
                                      help="Number of research is display on one page."
                                    />

                                    <Field
                                        label="KEYWORD"
                                        error=""
                                        help="Do not enter '#' character"
                                    >
                                        <BaseInput
                                            v-model="form.keyword"
                                            type="text"
                                            placeholder=""
                                        />
                                    </Field>

                                    <Field
                                        label="AUTHOR"
                                        error=""
                                    >
                                        <BaseInput
                                            v-model="form.author"
                                            type="text"
                                            placeholder=""
                                        />
                                    </Field>

<!--                                    <Field-->
<!--                                        label="JOURNAL NAME"-->
<!--                                        error=""-->
<!--                                    >-->
<!--                                        <BaseInput-->
<!--                                            v-model="form.journal_name"-->
<!--                                            type="text"-->
<!--                                            placeholder=""-->
<!--                                        />-->
<!--                                    </Field>-->

                                    <Field
                                        label="DOI"
                                        error=""
                                    >
                                        <BaseInput
                                            v-model="form.doi"
                                            type="text"
                                            placeholder="Ex. 10.3390/ijerph16193753"
                                        />
                                    </Field>

<!--                                    <BaseLabel-->
<!--                                        for="publication_date"-->
<!--                                    >-->
<!--                                        PUBLICATION DATE-->
<!--                                    </BaseLabel>-->
<!--                                    <BaseRadioGroup-->
<!--                                        v-model="form.publication_date_range"-->
<!--                                        :options="publication_date"-->
<!--                                        name="publication_date"-->
<!--                                        radio-type="base-with-border"-->
<!--                                    />-->

<!--                                    <VueDatePicker-->
<!--                                        @closed="checkCustomRange"-->
<!--                                        @cleared="disableButtonStatus = true; form.publication_date_range = 0"-->
<!--                                        v-if="showCustomRange"-->
<!--                                        v-model="form.custom_publication_date_range"-->
<!--                                        placeholder="Select year range"-->
<!--                                        range-->
<!--                                        year-picker :year-range="[dayjs(props.start_year).year(), dayjs(props.end_year).year()]"-->
<!--                                    />-->
                                </div>

                            </div>
                        </div>
                        <div class="py-2 px-4 bg-gray-50">
                            <div class="flex flex-col space-y-2 mt-4">
                              <Button
                                class="rounded-full"
                                intent="success"
                                size="xlarge"
                                :disabled="disableButtonStatus"
                                @click="searchButton()"
                              >
                                Search
                              </Button>

<!--                                <button-->
<!--                                  class="bg-green-800 p-2 text-white rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-700"-->
<!--                                  ref="checkoutButtonRef"-->
<!--                                  :disabled="disableButtonStatus"-->
<!--                                  @click="searchButton()"-->
<!--                                  :class="[disableButtonStatus ? 'cursor-not-allowed' : '']"-->
<!--                                >-->
<!--                                  Search-->
<!--                                </button>-->
                                <div class="flex-row justify-between">
                                  <Button
                                    class="w-1/2 rounded-full"
                                    intent="text"
                                    size="medium"
                                    @click="setIsOpen(false)"
                                  >
                                    Close
                                  </Button>
                                  <Button
                                    class="w-1/2 rounded-full"
                                    intent="text"
                                    size="medium"
                                    @click="clearAllFilter()"
                                  >
                                    Clear all filter
                                  </Button>
<!--                                    <button class="w-1/2 p-2 bg-white text-gray-500 hover:text-black rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black" @click="setIsOpen(false)">Close</button>-->
<!--                                    <button class="w-1/2 p-2 bg-white text-gray-500 hover:text-black rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black" @click="clearAllFilter()">Clear all filter</button>-->
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </TransitionChild>
        </Dialog>
    </TransitionRoot>

    <Head title="Welcome" />

<!--    <div class="min-h-screen" :style="{ backgroundImage: `url(${backgroundImgUrl})`, backgroundSize: 'contain' }">-->
    <div class="min-h-screen bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900" >
<!--    <div class="min-h-screen bg-[conic-gradient(at_top,_var(&#45;&#45;tw-gradient-stops))] from-sky-400 to-blue-800" >-->
<!--    <div class="min-h-screen bg-[radial-gradient(ellipse_at_center,_var(&#45;&#45;tw-gradient-stops))] from-blue-700 via-blue-800 to-gray-900" >-->
      <div class="flex w-full justify-end">
        <Alert :show="showAlert" :on-dismiss="() => (showAlert = false)" title="Import data success">
<!--          <p>ดำเนินการสร้างฐานข้อมูลเรียบร้อย</p>-->
        </Alert>
      </div>

      <button @click="setIsOpen(true)" class="p-4 bg-green-800 hover:bg-green-700 fixed top-6 z-10 left-6 rounded-full">
        <FunnelIcon class="w-8 h-8 text-white" />
      </button>

<!--    <Profile></Profile>-->
    <div class="flex justify-end mr-2" v-if="! props.researchs.total">
        <Button
            @click="importData"
            intent="text"
            size="medium"
            class="text-white"
        >
            Import
        </Button>
    </div>

    <div class="flex justify-end mr-2">
      <Button
        as="a"
        intent="text"
        size="medium"
        class="text-white"
        :href="route('export-research')"
      >
        Download
      </Button>
<!--        <button @click="createData" class="border p-2 rounded-lg text-white">Create Data</button>-->
    </div>

    <div class="flex justify-center text-5xl text-green-500 font-semibold mt-2 lg:mt-0 mb-4 w-full">
      <div class="flex relative w-3/4 justify-center items-center shadow-lg">
        <div class="flex items-center justify-center md:hidden w-40 h-40 bg-white rounded-full">SIMED</div>
        <img src="../Asset/images/banner.png" class="w-full object-fill h-40 hidden md:block" />
<!--          Faculty of Medicine Siriraj Hospital Electronic Research Finding-->
      </div>
    </div>

    <div class="flex w-full justify-center mb-2">
      <div class="flex-col w-full relative md:w-3/4 lg:w-3/4 mr-4 md:mr-0 ml-4 md:ml-0 justify-center bg-amber-200 p-2 rounded-md border border-gray-600">
        <div class="font-semibold underline text-lg mb-2"> Additional Filter (recommend to use at least one filter)</div>
<!--        <div v-if="form.title">-->
<!--           <span class="font-semibold">TITLE :: </span> <span class="font-semibold text-pink-500">{{ form.title }}</span>-->
<!--        </div>-->
        <div v-if="form.keyword">
          <span class="font-semibold">KEYWORD :: </span> <span class="font-semibold text-pink-500">{{ form.keyword }} </span>
        </div>
        <div v-if="form.first_author">
          <span class="font-semibold">FIRST AUTHOR :: </span> <span class="font-semibold text-pink-500">{{ form.first_author }} </span>
        </div>
        <div v-if="form.journal_name">
          <span class="font-semibold">JOURNAL NAME :: </span> <span class="font-semibold text-pink-500">{{ form.journal_name }} </span>
        </div>
        <div v-if="form.doi">
          <span class="font-semibold">DOI No. :: </span> <span class="font-semibold text-pink-500">{{ form.doi }} </span>
        </div>
        <div v-if="form.publication_date_range != 0 && form.publication_date_range != 'custom'">
          <span class="font-semibold">PUBLISH YEAR :: </span> <span class="font-semibold text-pink-500">{{ dayjs().year() - form.publication_date_range }} to {{ dayjs().year() }} </span>
        </div>
        <div v-if="form.publication_date_range == 'custom' && form.custom_publication_date_range?.length">
          <span class="font-semibold">PUBLISH YEAR :: </span> <span class="font-semibold text-pink-500">{{ form.custom_publication_date_range[0] }} to {{ form.custom_publication_date_range[1] }}</span>
        </div>
      </div>

    </div>

    <div class="flex w-full justify-center mb-2">
      <div class="relative w-full md:w-3/4 lg:w-3/4 mr-4 md:mr-0 ml-4 md:ml-0">
          <Field
            label="Basic search"
            error=""
          >
            <BaseInput
              v-model="form.title"
              type="text"
              placeholder="Search by title."
            />
          </Field>
<!--          <input v-model="form.title" type="text" id="search-dropdown" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg rounded-l-lg border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search Mockups, Logos, Design Templates...">-->
          <button @click="searchButton"
                  class="absolute top-5 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            <MagnifyingGlassIcon class="w-5 h-5" />
              <span class="sr-only">Search</span>
          </button>
      </div>
    </div>
    <div v-if="props.researchs.total && props.researchs.total > props.researchs.per_page && props.researchs.from" class="flex w-full justify-center mb-2">
        <Paginate class="relative w-full md:w-3/4 lg:w-3/4 mr-4 md:mr-0 ml-4 md:ml-0 justify-center bg-green-800 p-1 opacity-90 rounded-md" :pagination="props.researchs" />
    </div>

    <div
      v-for="(item, index) in props.researchs.data" :key="item.id"
      class="flex w-full justify-center mb-5"
    >
      <div class="relative w-full md:w-3/4 lg:w-3/4 mr-4 md:mr-0 ml-4 md:ml-0 px-4 py-3 bg-white rounded-md shadow-lg bg-opacity-10 backdrop-filter backdrop-blur-lg shadow-lg shadow-white/50">
        <div>
          <h1 class="mt-2 text-2xl font-light text-amber-200 ">{{ index + (props.researchs.from) }}. {{ item.title }}</h1>
          <p class="mt-1 text-md text-amber-400">
            <span>
              <Avatar
                shape="circle"
                size="base"
                name="RI"
                initials="RI"
                :src="item.person.image_url"
              />
            </span>
            {{ item.full_name }}

          </p>
          <p class="mt-1 text-md text-blue-400 ">ISBN: {{ item.isbn }}. ISSN: {{ item.issn }}. doi: {{ item.doi }}. {{ dayjs(item.publish_date).format('ll') }}. [ {{ dayjs(item.publish_date).toNow(true) }} ]</p>
          <p class="mt-1 text-md text-gray-400 ">{{ item.author }}</p>
        </div>

        <div class="mt-1 text-md font-light text-white">
<!--          {{ item.abstract }}-->
            <div v-if="item.abstract.startsWith('[')">
                {{ item.abstract }}
            </div>
            <Disclosure as="div" class="mt-2" v-slot="{ open }" v-else>
                <DisclosureButton
                    class="flex w-full justify-between rounded-lg bg-purple-100 px-4 py-2 text-left text-sm font-medium text-purple-900 hover:bg-purple-200 focus:outline-none focus-visible:ring focus-visible:ring-purple-500 focus-visible:ring-opacity-75"
                >
                    <span>Abstract</span>
                    <ChevronDoubleUpIcon
                        :class="open ? 'rotate-180 transform' : ''"
                        class="h-5 w-5 text-purple-500"
                    />
                </DisclosureButton>
                <DisclosurePanel class="px-4 pt-4 pb-2 text-sm text-white text-justify">
                    {{ item.abstract }}
                </DisclosurePanel>
            </Disclosure>

        </div>

<!--        <div class="mt-1 text-sm text-green-400 ">-->
<!--          KEYWORD:-->
<!--          <span v-if="item.tags" class="mx-2" v-for="(tag, tag_index) in item.tags.split('#')" :key="tag_index">#{{ tag }}</span>-->
<!--          <span v-else class="mx-2" >-</span>-->
<!--        </div>-->
          <div class="mt-1 text-sm text-green-400 ">
              KEYWORD:
              <span v-if="item.author_keyword" class="mx-2" >{{ item.author_keyword }}</span>
              <span v-else class="mx-2" >-</span>
          </div>
      </div>
    </div>

    <div v-if="props.researchs.total && props.researchs.total > props.researchs.per_page && props.researchs.from" class="flex w-full justify-center mt-2">
      <Paginate class="relative w-full md:w-3/4 lg:w-3/4 mr-4 md:mr-0 ml-4 md:ml-0 justify-center bg-green-800 p-1 opacity-90 rounded-md" :pagination="props.researchs" />
    </div>

    <div v-else class="space-y-2"></div>

    <div class="">
      <button v-if="toTopButton" @click="goToTop">
        <ChevronDoubleUpIcon class="fixed z-50 bottom-10 w-10 h-10 md:w-14 md:h-14 right-1 md:right-8 border-0 p-2 rounded-full drop-shadow-md bg-green-800 text-white font-bold hover:text-white" />
      </button>
    </div>

    </div>
</template>
