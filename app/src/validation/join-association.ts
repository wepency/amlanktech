import { z } from "zod"

export const joinAssociationSchema = z
  .object({
    association_id: z.string().min(1, "حقل مطلوب"),
    ownership_type: z.enum(["individual", "group"]),
    ownership_ratio: z.string().optional(),
    partners_amount: z.string().optional(),
    unit_name: z.string().min(3, "مطلوب"),
    unit_address: z.string().min(1, "حقل مطلوب"),
    water_meter_serial: z.string().regex(/^\d{7,}$/, "رقم غير صالح"),
    electricity_meter_serial: z.string().regex(/^\d{7,}$/, "رقم غير صالح"),
    fee_type_value: z.string().optional(),
    fee_type_id: z.string().optional(),
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
          .safeParse(obj.ownership_ratio).success
      ) {
        return true
      }
      return false
    },
    {
      path: ["ownership_ratio"],
      message: "الرجاء تحديد الشراكة",
    },
  )
