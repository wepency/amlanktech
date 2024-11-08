import React from "react"
import Link from "next/link"
import AmlackApi from "@/api"
import {Button} from "@mantine/core"
import {IconCheck, IconX} from "@tabler/icons-react"

import {PlansResponse} from "@/types/plans-response"

type Props = {}

const Pricing = async (props: Props) => {
    const plans = await AmlackApi.get<PlansResponse[]>("/plans")

    // console.log("🚀 ~ Pricing ~ plans:", plans)
    return (
        <section id="pricing" className="bg-gray-100">
            <div className="container py-20">
                <h3 className="mb-16 text-center text-lg font-medium lg:text-3xl">
                    اختر الباقة اللتي تناسبك
                </h3>
                <div className=" flex flex-wrap justify-center gap-4 md:gap-5 lg:gap-8">
                    {plans.data.map((element) => {
                        return (
                            <div
                                key={element.id}
                                className="w-full max-w-md divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm">
                                <div className="p-6 sm:px-8 text-center">
                                    <h2 className="text-lg font-medium text-gray-900">
                                        {element.name}
                                        <span className="sr-only">Plan</span>
                                    </h2>

                                    <p className="mt-2 sm:mt-4">
                                        <strong className="text-3xl font-bold text-gray-900 sm:text-4xl">
                                            {" "}
                                            {element.yearly_price} ر.س
                                        </strong>

                                        <span className="text-sm font-medium text-gray-700">/سنة</span>
                                    </p>

                                    <p className="mt-2 sm:mt-4 justify-content-center">
                                        تجدد سنويا <strong>{element.setup_fees} ر.س</strong>
                                    </p>

                                    <Button
                                        component={Link}
                                        href={`/register-association/${element.id}`}
                                        className="mt-8 w-full"
                                        variant="outline">
                                        اشترك الآن
                                    </Button>
                                </div>

                                <div className="p-6 sm:px-8">
                                    <p className="text-lg font-medium text-gray-900 sm:text-xl">
                                        المميزات
                                    </p>
                                    <ul role="list" className="mt-2 space-y-2 sm:mt-4">
                                        {element.description.map((element) => {
                                            return (
                                                <li key={element} className="flex items-center  gap-2  ">
                                                    <IconCheck stroke={1.5} className="text-Primary"/>
                                                    <span className="text-base font-medium text-gray-900">
                                                        {element}
                                                    </span>
                                                </li>
                                            )
                                        })}
                                    </ul>
                                </div>
                            </div>
                        )
                    })}
                </div>
            </div>
        </section>
    )
}

export default Pricing
