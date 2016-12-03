import java.io.IOException;
import java.util.StringTokenizer;
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.io.WritableComparable;
import org.apache.hadoop.io.WritableComparator;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.util.GenericOptionsParser;

public class TopRecords {

  public static class TokenizerMapper
       extends Mapper<Object, Text, IntWritable, IntWritable>{

    public void map(Object key, Text value, Context context
                    ) throws IOException, InterruptedException {

    try
    {
     String [] output = value.toString().split("\\s+");
     for(int i=0;i<output.length;i=i+2)
     {
     int value1 = Integer.parseInt(output[i]);
     int value2 = Integer.parseInt(output[i+1]);
     context.write(new IntWritable(value2),new IntWritable(value1));
    }
    }catch(Exception e)
    {
    System.out.println(e.getMessage());
    }
    }
  }

  public static class IntSumReducer
       extends Reducer<IntWritable,IntWritable,IntWritable,IntWritable> {

   int i=0;
    public void reduce(IntWritable key, Iterable<IntWritable> values,
                       Context context
                       ) throws IOException, InterruptedException {
   try{
   Configuration conf = context.getConfiguration();
   int count =Integer.parseInt(conf.get("Top"));

  if(i< count){

          for(IntWritable value: values){
          context.write(value,key);
          i++;
            if(i > count){
               break;
            }
           }
          }}catch(Exception e){
                 System.out.println(e.getMessage());
         }
        }
       }
	     public static class DescendingKeyComparator extends WritableComparator {
    protected DescendingKeyComparator() {
        super(IntWritable.class, true);
    }

    @SuppressWarnings("rawtypes")
    @Override
    public int compare(WritableComparable w1, WritableComparable w2) {
        IntWritable key1 = (IntWritable) w1;
        IntWritable key2 = (IntWritable) w2;
        return -1 * key1.compareTo(key2);
    }
  }


  public static void main(String[] args) throws Exception {
    Configuration conf = new Configuration();
    GenericOptionsParser optionParser = new GenericOptionsParser(conf, args);
    String[] remainingArgs = optionParser.getRemainingArgs();
    if(remainingArgs.length !=3 )
    {
    System.out.println("Enter <in> <out> 10");
    System.exit(2);
    }
    if(remainingArgs.length>2)
    {
    conf.set("Top",remainingArgs[2]);
    }
    Job job = Job.getInstance(conf, "histogram count");
    job.setJarByClass(TopRecords.class);
    job.setMapperClass(TokenizerMapper.class);
    job.setCombinerClass(IntSumReducer.class);
    job.setReducerClass(IntSumReducer.class);
    job.setSortComparatorClass(DescendingKeyComparator.class);
    job.setOutputKeyClass(IntWritable.class);
    job.setOutputValueClass(IntWritable.class);
    FileInputFormat.addInputPath(job, new Path(args[0]));
    FileOutputFormat.setOutputPath(job, new Path(args[1]));
    System.exit(job.waitForCompletion(true) ? 0 : 1);
  }
}
