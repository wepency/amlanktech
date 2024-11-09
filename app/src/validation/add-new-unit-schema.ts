import { z } from "zod"

export const AddNewUnitSchema = z
  .object({
    unit_name: z.string().min(3, "مطلوب"),
    association_id: z.string(),
    ownership_type: z.enum(["individual", "group"]),
    unit_address: z.string().min(1, "العنوان ملطوب"),
    water_meter_serial: z.string().regex(/^\s*\d+\s*$/, "رقم غير صالح"),
    electricity_meter_serial: z.string().regex(/^\s*\d+\s*$/, "رقم غير صالح"),
    partners_amount: z.string().optional(),
    partnership_ratio: z.string().optional(),
    fee_type_value: z.string().optional(),
    fee_type_id: z.string().optional(),
    unit_type: z.string()
  })
  .refine(
    (obj) => {
      if (obj.ownership_type !== "group") return true
      if (
        z
          .string()
          .min(1)
          .regex(/^\s*\d+\s*$/)
          .safeParse(obj.partners_amount).success
      ) {
        return true
      }
      return false
    },
    {
      path: ["partners_amount"],
      message: "الرجاء تحديد عدد الشركاء",
    },
  )
  .refine(
    (obj) => {
      if (obj.ownership_type !== "group") return true

      if (
        z
          .string()
          .min(1)
          .regex(/^\s*\d+\s*$/)
          .safeParse(obj.partnership_ratio).success
      ) {
        return true
      }
      return false
    },
    {
      path: ["partnership_ratio"],
      message: "الرجاء تحديد الشراكة",
    },
  )
