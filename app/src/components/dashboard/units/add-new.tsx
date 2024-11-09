"use client"

import React from "react"
import {useParams} from "next/navigation"
import AmlackApi from "@/api"
import {getAssociations} from "@/api/helpers/get-associations"
import {AddNewUnitSchema} from "@/validation/add-new-unit-schema"
import {DevTool} from "@hookform/devtools"
import {zodResolver} from "@hookform/resolvers/zod"
import {Button, Modal, Select, TextInput} from "@mantine/core"
import {useDisclosure} from "@mantine/hooks"
import {notifications} from "@mantine/notifications"
import {IconCirclePlus, IconPercentage} from "@tabler/icons-react"
import {useQuery, useQueryClient} from "@tanstack/react-query"
import axios from "axios"
import {Controller, SubmitHandler, useForm} from "react-hook-form"
import {z} from "zod"

import DynamicSelect from "@/components/ui/dynamic-select"

type Props = {}

const AddNewUnit = (props: Props) => {
    const [opened, {open, close}] = useDisclosure(false)

    const {association_id} = useParams() as { association_id: string }

    // form state using react hook form
    const {
        control,
        setError,
        formState: {errors, isSubmitting, isSubmitted},
        handleSubmit,
        reset,
        watch,
    } = useForm<z.infer<typeof AddNewUnitSchema>>({
        resolver: zodResolver(AddNewUnitSchema),
        defaultValues: {
            unit_name: "",
            association_id: association_id,
            ownership_type: "individual",
            water_meter_serial: "",
            electricity_meter_serial: "",
            partners_amount: "",
            partnership_ratio: "",
            fee_type_value: "",
            unit_type: ""
        },
    })

    const {data} = useQuery({
        queryKey: ["lists", "associations"],
        queryFn: getAssociations,
    })
    const selectedAssociation = data?.data.associations.find(
        (e) => e.id + "" === association_id,
    )

    const queryClient = useQueryClient()
    // handling adding a new unit
    const onSubmit: SubmitHandler<z.infer<typeof AddNewUnitSchema>> = async (data) => {
        data.fee_type_id = selectedAssociation!.feeType?.id + "" || ""

        try {
            const response = await AmlackApi.post("/units", data, {})

            await queryClient.invalidateQueries({
                queryKey: ["unit", association_id],
            })

            reset()
            notifications.show({
                title: "تمت العملية بنجاح",
                message:
                    "تم تقديم طلب اضافة الوحدة الخاص بك بنجاح, سيتم مراجعت طلبك في اقرب وقت ممكن",
            })
            close()
        } catch (error: any) {
            console.log(
                "🚀 ~ constonSubmit:SubmitHandler<z.infer<typeofAddNewUnitSchema>>= ~ error:",
                error,
            )
            if (axios.isAxiosError(error) && error.message == "Network Error") {
                setError("root", {
                    message: "الرجاء التاكد من اتصالك بالانترنت",
                })
                return
            }
            if (axios.isAxiosError(error) && error.response?.status == 401) {
                setError("root", {
                    message: "الرجاء تسجيل الدخول",
                })
                return
            }
            if (axios.isAxiosError(error) && error.response?.status == 422) {
                for (let key in error.response.data.errors[0]) {
                    setError(
                        //@ts-expect-error
                        key,
                        {message: error.response?.data?.errors[0]?.[key][0]},
                        {shouldFocus: true},
                    )
                }

                return
            }
            if (axios.isAxiosError(error) && error.message == "Network Error") {
                setError("root", {
                    message: "الرجاء التاكد من اتصالك بالانترنت",
                })
                return
            }
            if (error.message) {
                setError("root", {
                    message: error.message,
                })
                return
            }
        }
    }

    return (
        <>
            <Button
                onClick={open}
                color="green"
                className=" max-sm:pr-0"
                rightSection={
                    <span className="block shrink-0 ">
            <IconCirclePlus color="green" stroke={1}/>
          </span>
                }
                variant="outline">
                <span className="max-sm:hidden">اضافة وحدة</span>
            </Button>
            <Modal centered opened={opened} onClose={close} title="اضافة وحدة ">
                <form noValidate onSubmit={handleSubmit(onSubmit)}>
                    <div className=" space-y-3">
                        <Controller
                            name="association_id"
                            control={control}
                            render={({field}) => (
                                <DynamicSelect
                                    readOnly
                                    queryFn={getAssociations}
                                    queryKey="associations"
                                    label="أختر الجمعية"
                                    placeholder="اختر جمعية"
                                    formatData={(data) => {
                                        const associations = data?.data.associations.map(
                                            (element, index) => {
                                                return {value: element.id + "", label: element.name}
                                            },
                                        )
                                        return associations
                                    }}
                                    error={errors.association_id?.message}
                                    {...field}
                                />
                            )}
                        />
                        <Controller
                            name="unit_name"
                            control={control}
                            render={({field}) => (
                                <TextInput
                                    label="اسم الوحدة"
                                    placeholder="اسم الوحدة"
                                    error={errors.unit_name?.message}
                                    {...field}
                                />
                            )}
                        />

                        <Controller
                            name="unit_type"
                            control={control}
                            render={({ field, fieldState }) => (
                                <Select
                                    label="نوع العقار؟"
                                    data={[
                                        { label: "فيلا", value: "villa" },
                                        { label: "عمارة", value: "building" },
                                        { label: "شقة", value: "apartment" },
                                        { label: "مستودع", value: "warehouse" },
                                        { label: "محل تجاري", value: "shop" },
                                    ]}
                                    error={fieldState.error?.message} // Uses fieldState.error for the current field's error
                                    {...field} // Spread field props for full functionality
                                />
                            )}
                        />

                        <Controller
                            name="ownership_type"
                            control={control}
                            render={({field}) => (
                                <Select
                                    label="العقار يتبع لفرد ام مجموعة؟"
                                    data={[
                                        {
                                            label: "فرد",
                                            value: "individual",
                                        },
                                        {
                                            label: "مجموعة",
                                            value: "group",
                                        },
                                    ]}
                                    error={errors.ownership_type?.message}
                                    {...field}
                                />
                            )}
                        />
                        {watch("ownership_type") === "group" ? (
                            <>
                                <Controller
                                    name="partners_amount"
                                    control={control}
                                    render={({field}) => (
                                        <TextInput
                                            label="عدد الشركاء"
                                            placeholder="العدد"
                                            error={errors.partners_amount?.message}
                                            {...field}
                                        />
                                    )}
                                />
                                <Controller
                                    name="partnership_ratio"
                                    control={control}
                                    render={({field}) => (
                                        <TextInput
                                            leftSection={<IconPercentage stroke={1.4} size={20}/>}
                                            label="نسبة الشراكة"
                                            placeholder="النسبة"
                                            error={errors.partnership_ratio?.message}
                                            {...field}
                                        />
                                    )}
                                />
                            </>
                        ) : null}

                        <Controller
                            name="unit_address"
                            control={control}
                            render={({field}) => (
                                <TextInput
                                    {...field}
                                    error={errors.unit_address?.message}
                                    label="عنوان الوحدة"
                                    placeholder="عنوان الوحدة"
                                    required
                                />
                            )}
                        />

                        <Controller
                            name="water_meter_serial"
                            control={control}
                            render={({field}) => (
                                <TextInput
                                    {...field}
                                    error={errors.water_meter_serial?.message}
                                    label="رقم اشتراك المياه"
                                    placeholder="رقم اشتراك المياه"
                                    required
                                />
                            )}
                        />
                        <Controller
                            name="electricity_meter_serial"
                            control={control}
                            render={({field}) => (
                                <TextInput
                                    {...field}
                                    error={errors.electricity_meter_serial?.message}
                                    label="رقم اشتراك الكهرباء"
                                    placeholder="رقم اشتراك الكهرباء"
                                    required
                                />
                            )}
                        />
                        {selectedAssociation && selectedAssociation.feeType ? (
                            <Controller
                                name="fee_type_value"
                                control={control}
                                render={({field}) => (
                                    <TextInput
                                        label={selectedAssociation.feeType?.label}
                                        placeholder={selectedAssociation.feeType?.label}
                                        error={errors.fee_type_value?.message}
                                        {...field}
                                    />
                                )}
                            />
                        ) : null}
                        {errors.root ? (
                            <p className=" mt-5 text-center text-sm text-red-500">
                                {errors.root.message}
                            </p>
                        ) : null}
                        <Button loading={isSubmitting} type="submit" fullWidth mt="lg">
                            اضافة الوحدة
                        </Button>
                    </div>
                </form>
            </Modal>
            <DevTool control={control} placement="top-left"/>
        </>
    )
}

export default AddNewUnit
